<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="mb-3">
    <select id="myDropdown" multiple>
        <option value="content1">Content 1</option>
        <option value="content2">Content 2</option>
        <option value="content3">Content 3</option>
        <!-- Add more options as needed -->
    </select>
</div>

<script>
    var isCtrlPressed = false;

    // Event listener for Ctrl key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Control') {
            isCtrlPressed = true;
        }
    });

    // Event listener for Ctrl key release
    document.addEventListener('keyup', function(event) {
        if (event.key === 'Control') {
            isCtrlPressed = false;
        }
    });

    // Event listener for selecting options when Ctrl + z is pressed
    document.addEventListener('change', function(event) {
        if (isCtrlPressed && event.target && event.target.id === 'myDropdown') {
            var dropdown = event.target;
            var selectedOptions = [];

            for (var i = 0; i < dropdown.options.length; i++) {
                if (dropdown.options[i].selected) {
                    selectedOptions.push(dropdown.options[i].text);
                }
            }

            var textToCopy = selectedOptions.join('\n');
            navigator.clipboard.writeText(textToCopy).then(function() {
                console.log('Selected options copied to clipboard: \n' + textToCopy);
            }, function(err) {
                console.error('Unable to copy to clipboard: ', err);
            });
        }
    });
</script>



</body>
</html>