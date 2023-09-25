<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="invoice.css">
</head>
<body>
<div id="header-container">
    <div id="logo-container" style="margin-top: 10px;">
        <img src="troiod-logo-black.png" width="150px" alt="Troido Logo">
    </div>
    <div id="invoice-title"
         style="font-size: 20pt; font-weight: bold; letter-spacing: -1.5px; position: absolute; right: calc(1cm - 20px); top: 20px;">
        <img src='bluestrip.png' style='vertical-align: middle; padding-bottom: 5px; height: 40px;'>APP AUDITS
    </div>
</div>
<div style="margin-top: 50px;"></div>
<div style="display: flex; align-items: flex-end; position: relative;">
    <h1 style="font-size: 36pt; margin: 0; position: relative;">
        Audit Offer
        <span style="position: absolute; bottom: 0; left: 0; width: 100%; border-bottom: 5px solid #000;"></span>
    </h1>
    <span style="flex-grow: 1; border-top: 5px solid #ababab; margin-left: -1px;"></span>
</div>


<h2 style="font-weight: bold; color: #2C2C36 ;">Subject: Comprehensive AppAudit Reveals Crucial UX und Programming
    Improvements</h2>

<!-- Add the requested text, bullet points, and additional text -->
<p style="font-family: Helvetica, sans-serif; font-weight: normal; font-size: 20px; line-height: 1.2; color: #2C2C36; margin-bottom: 5px;">
    Navigation and User Flow: The app´s navigation is confusing, and users encounter difficulties finding key features.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
    standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
    type specimen book.
</p>

<h2 style="font-weight: bold; color: #2C2C36 ;">
    <ul style="list-style-type: disc; padding-left: 20px;">
        <li>Code Structure</li>
    </ul>
</h2>

<p style="font-family: Helvetica, sans-serif; font-weight: normal; font-size: 20px; line-height: 1.2; color: #2C2C36; margin-bottom: 40px;">
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
    standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
    type specimen book.
</p>

<div id="selected-blocks">
    <!-- Display the selected blocks from JSON data -->
    <?php
    if (isset($_POST['selectedBlocks'])) {
        $selectedBlocks = json_decode($_POST['selectedBlocks'], true);
        $jsonData = file_get_contents('data.json');
        $data = json_decode($jsonData, true);
        foreach ($data as $block) {
            if (in_array($block['title'], $selectedBlocks)) {
                echo '<div class="block">';
                echo '<div class="icon">';
                echo '<img src="' . $block['icon'] . '" alt="' . $block['title'] . '">';
                echo '</div>';
                echo '<div class="info">';
                echo '<h2><span class="blue-line">' . $block['title'] . '</span></h2>'; // changed line
                echo '<p>' . $block['description'] . '</p>';
                echo '<ul style="list-style-type: disc; padding-left: 20px;">'; // added styling for bullet points
                foreach ($block['bulletpoints'] as $point) {
                    echo '<li>' . $point . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
        }
    } else {
        echo '<p>No blocks are selected in the invoice.</p>';
    }
    ?>
</div>

<div>
    <h2 class="unselected-heading">The following Audit Areas are not necessarily necessary, but can be added:</h2>

    <div id="unselected-blocks">
        <?php
        foreach ($data as $block) {
            if (!in_array($block['title'], $selectedBlocks)) {
                echo '<div class="block unselected" data-block-id="' . htmlspecialchars($block['title']) . '" 
                        onclick="moveToSelected(this)">';
                echo '<div class="icon">';
                echo '<img src="' . $block['icon'] . '" alt="' . $block['title'] . '">';
                echo '</div>';
                echo '<div class="info">';
                echo '<h2>' . $block['title'] . '</h2>';
                echo '<p>' . $block['description'] . '</p>';
                echo '<ul>';
                foreach ($block['bulletpoints'] as $point) {
                    echo '<li>' . $point . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<script>
    function moveToSelected(block) {
        const selectedBlocksDiv = document.getElementById('selected-blocks');
        block.onclick = null; // remove the click event handler
        block.classList.remove('unselected');
        selectedBlocksDiv.appendChild(block);
    }
</script>
<style>
    #invoice-blocks ul {
        list-style: none;
        padding: 0;
    }

    .block {
        background-color: #ffffff;
        border: 1px solid #ffffff;
        margin: 10px 0;
        padding: 10px;
        margin-bottom: 30px;

    }

    /* Style for the header container */
    #header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Style for the large title "App Audits" */
    #invoice-title {
        margin-right: 20px;
    }

    .info {
        margin-left: 1cm;
        margin-right: 1cm;
    }

    body {
        margin-left: 1cm;
        margin-right: 1cm;
    }

    @media print  {

        body {
            -webkit-print-color-adjust: exact; /* Chrome, Safari */
            color-adjust: exact; /* Firefox */
        }

        .icon img {
            margin-left: 40px; /* Add a margin to the left for images inside the block during printing */
        }
        /* .block.unselected, .unselected-heading{
            display: none;
        } */
        .block, .unselected-heading, #unselected-blocks {
            page-break-inside: avoid !important;
        }
        * {
            float: none;
            position: static;
        }

        @page {
            size: 12in 17in;
            margin: 2cm;
        }
        body {
            width: 90%;
            height: 100%;
        }
    }


    /* h1 span {
         background-color: #000 !important;
         height: 5px !important;
         /* Print-specific styles */
    }
        blue-line {
        border-left: 4px solid blue;
        padding-left: 8px;
        border-top-left-radius: 2px;
        border-bottom-left-radius: 2px;
    }
}
</style>

</body>
</html>
