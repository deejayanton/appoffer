<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Inspection Offer</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleSelected(item) {
            if (item.classList.contains('selected')) {
                item.classList.remove('selected');
            } else {
                item.classList.add('selected');
            }
            displaySelectedBlocks(); // Call the funktion to update the selected blocks display
        }

        function displaySelectedBlocks() {
            const selectedBlocksContainer = document.getElementById('selected-blocks');
            const selectedBlockElements = document.querySelectorAll('.block.selected');
            selectedBlocksContainer.innerHTML = ''; // Clear the container first

            if (selectedBlockElements.length === 0) {
                selectedBlocksContainer.innerHTML = '<p>No blocks are selected.</p>';
            } else {
                const ul = document.createElement('ul');
                selectedBlockElements.forEach((block) => {
                    const li = document.createElement('li');
                    li.textContent = block.querySelector('h2').textContent;
                    ul.appendChild(li);
                });
                selectedBlocksContainer.appendChild(ul);
            }
        }

        function redirectToInvoice() {
            const selectedBlocks = [];
            const selectedBlockElements = document.querySelectorAll('.block.selected');

            selectedBlockElements.forEach((block) => {
                selectedBlocks.push(block.dataset.blockId);
            });

            if (selectedBlocks.length === 0) {
                alert('No blocks are selected.');
            } else {
                // Convert the selected blocks to JSON and put them intp
                document.getElementById('selectedBlocksInput').value = JSON.stringify(selectedBlocks);
                document.getElementById('offer-form').submit();
            }
        }
    </script>
</head>
<body>
<!-- Container for the logo -->
<div id="logo-container">
    <img src="troido-logo.png" width="300px" alt="Troido Logo">
</div>

<?php
// Read JSON data from json file
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

foreach ($data as $block) {
    echo '<div class="block" data-block-id="' . htmlspecialchars($block['title']) . '" onclick="toggleSelected(this)">';
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
?>

<div id="selected-blocks">
    <h2>Selected Offer</h2>
    <!-- showed there -->
</div>

<div id="offer-container">
    <form id="offer-form" action="invoice.php" method="post">
        <input type="hidden" id="selectedBlocksInput" name="selectedBlocks" value="">
        <button type="button" class="button" onclick="redirectToInvoice()">Make an Offer</button>
    </form>
</div>

<!-- clone blocks and then sent it to invoice -->
<div id="cloned-selected-blocks" style="display: none;"></div>

<script>
    // Display initially selected blocks on page load
    displaySelectedBlocks();
</script>

</body>
</html>
