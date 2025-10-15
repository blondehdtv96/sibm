<?php

namespace App\Services;

class HtmlPurifierService
{
    /**
     * Purify HTML content to prevent XSS attacks
     *
     * @param string|null $html
     * @return string
     */
    public function purify(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Configuration for allowed tags and attributes
        $allowedTags = [
            'p', 'br', 'strong', 'em', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'ul', 'ol', 'li', 'a', 'img', 'blockquote', 'code', 'pre',
            'table', 'thead', 'tbody', 'tr', 'th', 'td', 'div', 'span'
        ];

        $allowedAttributes = [
            'a' => ['href', 'title', 'target', 'rel'],
            'img' => ['src', 'alt', 'title', 'width', 'height'],
            'div' => ['class'],
            'span' => ['class'],
            'table' => ['class'],
            'td' => ['colspan', 'rowspan'],
            'th' => ['colspan', 'rowspan'],
        ];

        // Strip all tags except allowed ones
        $html = strip_tags($html, '<' . implode('><', $allowedTags) . '>');

        // Use DOMDocument for more sophisticated cleaning
        if (class_exists('DOMDocument')) {
            $dom = new \DOMDocument();
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            // Remove dangerous attributes
            $xpath = new \DOMXPath($dom);
            $nodes = $xpath->query('//*[@onclick or @onerror or @onload or @onmouseover or @onfocus or @onblur]');
            
            foreach ($nodes as $node) {
                $attributes = [];
                foreach ($node->attributes as $attr) {
                    if (strpos(strtolower($attr->name), 'on') === 0) {
                        $attributes[] = $attr->name;
                    }
                }
                foreach ($attributes as $attr) {
                    $node->removeAttribute($attr);
                }
            }

            // Clean attributes based on allowed list
            $allNodes = $xpath->query('//*');
            foreach ($allNodes as $node) {
                $tagName = strtolower($node->nodeName);
                $allowedAttrs = $allowedAttributes[$tagName] ?? [];
                
                $attributes = [];
                foreach ($node->attributes as $attr) {
                    if (!in_array($attr->name, $allowedAttrs)) {
                        $attributes[] = $attr->name;
                    }
                }
                
                foreach ($attributes as $attr) {
                    $node->removeAttribute($attr);
                }

                // Sanitize href and src attributes
                if ($node->hasAttribute('href')) {
                    $href = $node->getAttribute('href');
                    if (!$this->isValidUrl($href)) {
                        $node->removeAttribute('href');
                    }
                }

                if ($node->hasAttribute('src')) {
                    $src = $node->getAttribute('src');
                    if (!$this->isValidUrl($src)) {
                        $node->removeAttribute('src');
                    }
                }
            }

            $html = $dom->saveHTML();
            
            // Remove XML declaration
            $html = preg_replace('/^<!DOCTYPE.+?>/', '', $html);
            $html = str_replace(['<html>', '</html>', '<body>', '</body>'], '', $html);
        }

        // Additional security: escape any remaining script tags
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $html);
        $html = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', '', $html);
        $html = preg_replace('/<embed\b[^>]*>/is', '', $html);

        return trim($html);
    }

    /**
     * Validate URL to prevent javascript: and data: schemes
     *
     * @param string $url
     * @return bool
     */
    private function isValidUrl(string $url): bool
    {
        $url = strtolower(trim($url));
        
        // Block dangerous protocols
        $dangerousProtocols = ['javascript:', 'data:', 'vbscript:', 'file:'];
        foreach ($dangerousProtocols as $protocol) {
            if (strpos($url, $protocol) === 0) {
                return false;
            }
        }

        // Allow relative URLs, http, https, mailto
        if (preg_match('/^(https?:\/\/|mailto:|\/|#)/', $url)) {
            return true;
        }

        // Allow relative paths
        if (!preg_match('/^[a-z]+:/i', $url)) {
            return true;
        }

        return false;
    }

    /**
     * Sanitize plain text input
     *
     * @param string|null $text
     * @return string
     */
    public function sanitizeText(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Strip all HTML tags
        $text = strip_tags($text);
        
        // Remove null bytes
        $text = str_replace(chr(0), '', $text);
        
        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        
        return trim($text);
    }

    /**
     * Sanitize filename to prevent directory traversal
     *
     * @param string $filename
     * @return string
     */
    public function sanitizeFilename(string $filename): string
    {
        // Remove directory traversal attempts
        $filename = str_replace(['../', '..\\', '../', '..\\'], '', $filename);
        
        // Remove null bytes
        $filename = str_replace(chr(0), '', $filename);
        
        // Keep only safe characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        return $filename;
    }
}
