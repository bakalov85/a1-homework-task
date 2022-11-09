<?php declare(strict_types=1);

// A global handle to the MySQL connection.
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conn, "utf8");

$allowedColors = ['white', 'silver', 'gray', 'black', 'red', 'maroon', 'yellow', 'olive', 
        'lime', 'green', 'aqua', 'teal', 'blue', 'navy', 'fuchsia', 'purple'];

// Prints a menu by given array of "linkLocation" => "linkTitle"
function printMenu(array $menuItems): void
{
    echo "<ul id='main-menu'>";
    foreach($menuItems as $linkLocation => $linkTitle){
        echo "<li><a href='" . $linkLocation . "'>" . $linkTitle . "</a></li>";
    }
    echo "</ul>";
}

function getRanges(): array
{
    global $conn;
	
    $sql = 'SELECT `ranges` FROM `a1_task`.`ranges`';
    $query = mysqli_query($conn, $sql);

    $result = [];
    
    while($row = mysqli_fetch_row($query)) {
        $result[] = $row;
    }
    
    return $result;
}

// validate that the range is something like this: "green,-12,blue,-3,yellow,5,red"
function validateRange(string $range): bool
{
    // Ok, I know using global variables is not good, but since for this task I am not using a modern OOP framework,
    // but the old procedural style, this is the fastest way I came upon.
    global $allowedColors;
    $rangeArr = explode(',', $range);

    // the array length must be odd
    if (count($rangeArr) % 2 !== 1) {
        return false;
    }

    // check colors. they are the even indexes
    for($i = 0; $i < count($rangeArr); $i+=2) {
        if(!in_array($rangeArr[$i], $allowedColors)) {
            return false;
        }
    }

    // check numbers. they are the odd indexes
    for($i = 1; $i < count($rangeArr) - 1; $i+=2) {
        if(!is_numeric($rangeArr[$i])) {
            return false;
        }
        
        // every next number must be bigger than the previous number
        if ($i >= 3) {
            if((int)$rangeArr[$i] <= (int)$rangeArr[$i - 2]) {
                return false;
            }
        }
    }

    return true;
}

function addRange(string $range): bool
{
    global $conn;

    try {
        $stmt = mysqli_prepare($conn, 'INSERT INTO `a1_task`.`ranges` (`ranges`) VALUES (?)');
        // 's' means that the `ranges` param is of type string
        // htmlspecialchars() is for preventing XSS attack
        $escapedParam = htmlspecialchars($range);
        $stmt->bind_param('s', $escapedParam);

        $stmt->execute();
    } catch (\Exception $e) {
        return false;
    }

    return true;
}

function printSelectElement(string $id, array $items): void
{
    echo "<select id={$id}>";
    
    foreach($items as $item) {
        echo "<option>{$item[0]}</option>";
    }

    echo '</select>';
}