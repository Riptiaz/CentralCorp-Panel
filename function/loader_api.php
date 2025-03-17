<?php

function getForgeBuilds($mcVersion) {
    $url = "https://files.minecraftforge.net/net/minecraftforge/forge/index_$mcVersion.html";
    $html = file_get_contents($url);
    $builds = [];

    if ($html) {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $links = $xpath->query('//a[contains(@href, "maven.minecraftforge.net/net/minecraftforge/forge/")]');

        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('/forge\/([\d.]+-[\d.]+-[\d.]+)/', $href, $matches)) {
                $builds[] = $matches[1];
            }
        }
    }

    return array_unique($builds);
}

if (isset($_GET['loader']) && isset($_GET['mc_version'])) {
    $loader = $_GET['loader'];
    $mcVersion = $_GET['mc_version'];
    $builds = [];

    if ($loader === 'forge') {
        $builds = getForgeBuilds($mcVersion);
    }

    header('Content-Type: application/json');
    echo json_encode(['builds' => $builds]);
}
?>
