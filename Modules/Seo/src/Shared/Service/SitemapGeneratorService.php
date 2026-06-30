<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\Service;

use Maatify\Seo\Exception\SeoInvalidArgumentException;
use Maatify\Seo\Shared\DTO\Sitemap\SitemapGenerationResultDTO;
use Maatify\Seo\Shared\DTO\Sitemap\SitemapIndexEntryDTO;
use Maatify\Seo\Shared\DTO\Sitemap\SitemapUrlDTO;
use XMLWriter;

final readonly class SitemapGeneratorService
{
    /**
     * @param list<SitemapUrlDTO> $urls
     */
    public function generateUrlSitemap(array $urls): SitemapGenerationResultDTO
    {
        if ($urls === []) {
            throw SeoInvalidArgumentException::emptyField('urls');
        }

        $writer = $this->createWriter();
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        if ($this->containsAlternates($urls)) {
            $writer->writeAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
        }

        foreach ($urls as $url) {
            $this->writeUrl($writer, $url);
        }

        $writer->endElement();
        $writer->endDocument();

        return new SitemapGenerationResultDTO($this->flushWriter($writer), count($urls), 'urlset');
    }

    /**
     * @param list<SitemapIndexEntryDTO> $entries
     */
    public function generateSitemapIndex(array $entries): SitemapGenerationResultDTO
    {
        if ($entries === []) {
            throw SeoInvalidArgumentException::emptyField('entries');
        }

        $writer = $this->createWriter();
        $writer->startElement('sitemapindex');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($entries as $entry) {
            $this->writeIndexEntry($writer, $entry);
        }

        $writer->endElement();
        $writer->endDocument();

        return new SitemapGenerationResultDTO($this->flushWriter($writer), count($entries), 'sitemapindex');
    }

    /**
     * @param list<SitemapUrlDTO> $urls
     */
    private function containsAlternates(array $urls): bool
    {
        foreach ($urls as $url) {
            if (!$url instanceof SitemapUrlDTO) {
                throw SeoInvalidArgumentException::emptyField('urls');
            }
            if ($url->alternates !== []) {
                return true;
            }
        }

        return false;
    }

    private function writeUrl(XMLWriter $writer, SitemapUrlDTO $url): void
    {
        $writer->startElement('url');
        $writer->writeElement('loc', trim($url->loc));

        if ($url->lastmod !== null) {
            $writer->writeElement('lastmod', trim($url->lastmod));
        }
        if ($url->changefreq !== null) {
            $writer->writeElement('changefreq', $url->changefreq);
        }
        if ($url->priority !== null) {
            $writer->writeElement('priority', number_format($url->priority, 1, '.', ''));
        }

        foreach ($url->alternates as $alternate) {
            $writer->startElement('xhtml:link');
            $writer->writeAttribute('rel', 'alternate');
            $writer->writeAttribute('hreflang', strtolower(trim($alternate->hreflang)));
            $writer->writeAttribute('href', trim($alternate->url));
            $writer->endElement();
        }

        $writer->endElement();
    }

    private function writeIndexEntry(XMLWriter $writer, SitemapIndexEntryDTO $entry): void
    {
        $writer->startElement('sitemap');
        $writer->writeElement('loc', trim($entry->loc));

        if ($entry->lastmod !== null) {
            $writer->writeElement('lastmod', trim($entry->lastmod));
        }

        $writer->endElement();
    }

    private function createWriter(): XMLWriter
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');

        return $writer;
    }

    private function flushWriter(XMLWriter $writer): string
    {
        $xml = $writer->outputMemory();
        if ($xml === '') {
            throw SeoInvalidArgumentException::emptyField('xml');
        }

        return $xml;
    }
}
