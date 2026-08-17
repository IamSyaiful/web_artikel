<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

class RichTextSanitizer
{
    /**
     * Sanitize the limited HTML produced by the movie editor.
     */
    public function clean(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return $html;
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $flags = LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING;
        $document->loadHTML('<?xml encoding="UTF-8"><div id="rich-text-root">'.$html.'</div>', $flags);

        $root = $document->getElementById('rich-text-root');

        if (! $root) {
            return e($html);
        }

        $this->sanitizeChildren($root);

        $result = '';

        foreach ($root->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        return trim($result);
    }

    private function sanitizeChildren(DOMNode $parent): void
    {
        $allowedTags = [
            'p', 'h2', 'h3', 'h4', 'strong', 'b', 'em', 'i', 'u',
            'ul', 'ol', 'li', 'blockquote', 'br', 'a',
        ];

        for ($index = $parent->childNodes->length - 1; $index >= 0; $index--) {
            $node = $parent->childNodes->item($index);

            if (! $node) {
                continue;
            }

            if ($node->nodeType === XML_ELEMENT_NODE) {
                $element = $node;
                $tag = strtolower($element->nodeName);

                if (! in_array($tag, $allowedTags, true)) {
                    if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form'], true)) {
                        $element->parentNode?->removeChild($element);
                    } else {
                        $this->removeElementPreservingText($element);
                    }

                    continue;
                }

                $this->sanitizeAttributes($element, $tag);
                $this->sanitizeChildren($element);
            }
        }
    }

    private function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowedAttributes = $tag === 'a'
            ? ['href', 'title', 'target', 'rel']
            : [];

        for ($index = $element->attributes->length - 1; $index >= 0; $index--) {
            $attribute = $element->attributes->item($index);

            if (! $attribute || ! in_array(strtolower($attribute->name), $allowedAttributes, true)) {
                if ($attribute) {
                    $element->removeAttribute($attribute->name);
                }
            }
        }

        if ($tag !== 'a' || ! $element->hasAttribute('href')) {
            return;
        }

        $href = trim($element->getAttribute('href'));
        $scheme = parse_url($href, PHP_URL_SCHEME);
        $isSafe = $scheme === null || in_array(strtolower($scheme), ['http', 'https', 'mailto'], true);

        if (! $isSafe) {
            $element->removeAttribute('href');
        }

        if ($element->getAttribute('target') === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private function removeElementPreservingText(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }
}
