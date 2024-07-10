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

        // Find all versions inside <td class="download-version">
        $versionsNodeList = $xpath->query('//td[@class="download-version"]');

        foreach ($versionsNodeList as $versionNode) {
            // Get the text content of the version node
            $version = trim($versionNode->nodeValue);
            
            // Add Minecraft version prefix if the version is not empty
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
