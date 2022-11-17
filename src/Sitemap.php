<?php

namespace Ptrufanov1\SitemapGenerator;

use Exception;
use Ptrufanov1\SitemapGenerator\Exceptions\{FileCreateException,
	InvalidChangefreqValueException,
	InvalidDateTimeFormatException,
	InvalidLocValueException,
	InvalidPageDataException,
	InvalidPriorityValueException,
	PermissionDeniedException,
	UnknownTagException};
use XMLWriter;

class Sitemap {

	private static array $keyPosition = [
		'loc' => 0,
		'lastmod' => 1,
		'priority' => 2,
		'changefreq' => 3,
	];

	public static array $availableChangefreq = [
		'always',
		'hourly',
		'daily',
		'weekly',
		'monthly',
		'yearly',
		'never',
	];

	public function __construct(private array $pages, private string $fileName) {}

	/**
	 * @throws Exception
	 */
	public static function load(array $pages, string $fileName = 'sitemap'): self {
		self::validateData($pages);

		$pagesPrepared = self::processingData($pages);
		return new static($pagesPrepared, $fileName);
	}

	/**
	 * @throws Exception
	 */
	private static function validateData(array $pages):void {
		foreach ($pages as $pageData) {
			if (!is_array($pageData) || !count($pageData)) {
				throw new InvalidPageDataException();
			}

			foreach ($pageData as $p => $v) {
				switch ($p) {
					case 'loc':
						if (filter_var($v, FILTER_VALIDATE_URL, FILTER_FLAG_HOSTNAME | FILTER_FLAG_PATH_REQUIRED) === false || mb_strlen($v) > 2048) {
							throw new InvalidLocValueException($v);
						}
						break;
					case 'lastmod':
						if (date_parse($v)["error_count"]) {
							throw new InvalidDateTimeFormatException();
						}
						break;
					case 'priority':
						$vf = floatval($v);
						if ($vf !== $v || $vf < 0 || $vf > 1) {
							throw new InvalidPriorityValueException();
						}
						break;
					case 'changefreq':
						if (!in_array(mb_strtolower($v), self::$availableChangefreq)) {
							throw new InvalidChangefreqValueException();
						}
						break;
					default:
						throw new UnknownTagException($p);
				}
			}
		}
	}

	private static function processingData(array $pages) :array {
		foreach ($pages as $i => $page) {
			foreach (self::dataSort($page) as $p => $v) {

				$p =  mb_strtolower($p);

				if ($p == 'priority') {
					$v = number_format($v, 1);
				}

				$pages[$i][$p] = htmlentities(mb_strtolower($v));
			}
		}
		return $pages;
	}

	/**
	 * @throws Exception
	 */
	public function saveXml(string $path): bool {
		$xmlWriter = new XMLWriter();
		$xmlWriter->openMemory();
		$xmlWriter->setIndent(true);
		$xmlWriter->setIndentString('	');
		$xmlWriter->startDocument('1.0', 'UTF-8');
		$xmlWriter->startElement('urlset');
		$xmlWriter->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlWriter->writeAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

		foreach ($this->pages as $pageData) {
			$xmlWriter->startElement('url');

			$xmlWriter->startElement('loc');
			$xmlWriter->text($pageData['loc']);
			$xmlWriter->endElement();

			$xmlWriter->startElement('lastmod');
			$xmlWriter->text($pageData['lastmod']);
			$xmlWriter->endElement();

			$xmlWriter->startElement('priority');
			$xmlWriter->text($pageData['priority']);
			$xmlWriter->endElement();

			$xmlWriter->startElement('changefreq');
			$xmlWriter->text($pageData['changefreq']);
			$xmlWriter->endElement();

			$xmlWriter->endElement();
		}

		$xmlWriter->endElement();
		$xmlWriter->endDocument();

		return $this->saveToFile($path, 'xml', $xmlWriter->outputMemory());
	}

	/**
	 * @throws Exception
	 */
	public function saveCsv(string $path): bool {
		$content = implode(';', array_keys(self::dataSort(self::$keyPosition)));
		$content .= PHP_EOL;
		foreach ($this->pages as $pageData) {
			$content .= implode(';', $pageData);
			$content .= PHP_EOL;
		}
		return $this->saveToFile($path, 'csv', $content);
	}

	/**
	 * @throws Exception
	 */
	public function saveJson(string $path): bool {
		return $this->saveToFile($path, 'json',
			json_encode($this->pages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES )
		);
	}

	/**
	 * @throws Exception
	 */
	private function saveToFile(string $path, string $fileType, string $content): bool {
		if (file_put_contents($this->checkPath($path, $fileType), $content) === false) {
			throw new FileCreateException();
		}
		return true;
	}

	/**
	 * @throws Exception
	 */
	private function checkPath(string $path, string $fileType): string {
		if (!is_dir($path) && !@mkdir($path, 0755, true)) {
			throw new PermissionDeniedException();
		}
		return $path."/$this->fileName.$fileType";
	}

	private static function dataSort(array $data): array {
		uksort($data, fn($a, $b) => self::$keyPosition[$a] > self::$keyPosition[$b]? 1: -1);
		return $data;
	}

}