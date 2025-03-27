<?php

use Illuminate\Support\HtmlString;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

function sanitize_html($html)
{
  if (is_null($html)) return null;

  $htmlSanitizer = new HtmlSanitizer(
    (new HtmlSanitizerConfig())->allowSafeElements()
  );

  return new HtmlString($htmlSanitizer->sanitize($html));
}
