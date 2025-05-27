<?php

if (!function_exists('svg_icon')) {
    /**
     * Load an SVG icon from the public/images/icons folder
     *
     * @param string $name SVG filename without .svg extension
     * @param array $attributes Optional HTML attributes to inject into the <svg> tag
     * @return string Rendered SVG or comment if not found
     */
    function svg_icon($name, $attributes = [])
    {
        $path = public_path("images/icons/{$name}.svg");

        if (!file_exists($path)) {
            return "<!-- SVG {$name} not found -->";
        }

        $svg = file_get_contents($path);

        foreach ($attributes as $key => $value) {
            $svg = preg_replace('/<svg /', "<svg {$key}=\"{$value}\" ", $svg, 1);
        }

        return $svg;
    }
}
