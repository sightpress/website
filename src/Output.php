<?php

declare(strict_types=1);

namespace SightPress\Website;

/**
 * The files one build produces, kept in memory until they are written or compared with the files on disk.
 * Everything else in the output folder (assets, brand files, robots.txt …) is hand-made and never touched.
 */
final class Output
{
    /** Files and folders that belong to the build. */
    public const array GENERATED = [
        '404.html', 'index.html', 'llms.txt', 'sitemap.xml', 'about', 'accessibility', 'blog', 'faq', 'features',
    ];

    /** @var array<string, string> path relative to the output folder => content */
    private array $files = [];

    public function add(string $path, string $content): void
    {
        $path = ltrim($path, '/');
        if (str_ends_with($path, '/') || $path === '') {
            $path .= 'index.html';
        }
        $root = explode('/', $path)[0];
        if (!\in_array($root, self::GENERATED, true)) {
            throw new \LogicException("The build may not write $path: add its top folder to Output::GENERATED.");
        }
        if (isset($this->files[$path])) {
            throw new \LogicException("Two pages want the same file: $path.");
        }
        $this->files[$path] = rtrim($content) . "\n";
    }

    /** @return array<string, string> */
    public function files(): array
    {
        ksort($this->files);

        return $this->files;
    }

    /** Replaces every generated file in $directory with this build. */
    public function write(string $directory): void
    {
        foreach (self::GENERATED as $name) {
            self::remove($directory . '/' . $name);
        }
        foreach ($this->files() as $path => $content) {
            $target = $directory . '/' . $path;
            if (!is_dir(\dirname($target)) && !mkdir(\dirname($target), 0o755, true)) {
                throw new \RuntimeException('Could not create ' . \dirname($target));
            }
            file_put_contents($target, $content);
        }
    }

    /**
     * Compares this build with the generated files in $directory.
     *
     * @return list<string> one line per difference; empty when they match
     */
    public function compare(string $directory): array
    {
        $onDisk = [];
        foreach (self::GENERATED as $name) {
            foreach (self::list($directory, $name) as $path) {
                $onDisk[$path] = true;
            }
        }
        $differences = [];
        foreach ($this->files() as $path => $content) {
            if (!isset($onDisk[$path])) {
                $differences[] = "missing: public/$path";
            } elseif (file_get_contents($directory . '/' . $path) !== $content) {
                $differences[] = "changed: public/$path";
            }
            unset($onDisk[$path]);
        }
        foreach (array_keys($onDisk) as $path) {
            $differences[] = "not made by the build: public/$path";
        }

        return $differences;
    }

    /** @return list<string> */
    private static function list(string $directory, string $name): array
    {
        $path = $directory . '/' . $name;
        if (is_file($path)) {
            return [$name];
        }
        if (!is_dir($path)) {
            return [];
        }
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            $files[] = substr($file->getPathname(), \strlen($directory) + 1);
        }
        sort($files);

        return $files;
    }

    private static function remove(string $path): void
    {
        if (is_file($path) || is_link($path)) {
            unlink($path);

            return;
        }
        if (!is_dir($path)) {
            return;
        }
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );
        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
        }
        rmdir($path);
    }
}
