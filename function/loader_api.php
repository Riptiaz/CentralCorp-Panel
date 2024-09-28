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
        $versionsNodeList = $xpath->query('//td[@class="download-version"]');

        foreach ($versionsNodeList as $versionNode) {
            $version = trim($versionNode->nodeValue);
            if (!empty($version)) {
                $builds[] = "$mcVersion-$version";
            }
        }
    }

    return $builds;
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
