<?php
function getForgeBuilds($mcVersion) {
    $url = "https://files.minecraftforge.net/net/minecraftforge/forge/index_$mcVersion.html";
    $html = @file_get_contents($url);

    if (!$html) {
        return [];
    }

    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);
    $builds = [];

    $versionsNodeList = $xpath->query('//td[@class="download-version"]');
    if ($versionsNodeList->length > 0) {
        foreach ($versionsNodeList as $versionNode) {
            $version = trim($versionNode->nodeValue);
            if (!empty($version)) {
                $builds[] = "$mcVersion-$version";
            }
        }
    }

    $links = $xpath->query('//a[contains(@href, "maven.minecraftforge.net/net/minecraftforge/forge/")]');
    if ($links->length > 0) {
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
