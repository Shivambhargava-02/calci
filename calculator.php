<?php
/**
 * Simple Calculator Program
 * Performs basic arithmetic operations: addition, subtraction, multiplication, and division
 * Handles error cases like division by zero and invalid input
 */

// Initialize variables
$result = '';
$error = '';
$num1 = '';
$num2 = '';
$operation = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize input
    $num1 = trim($_POST['num1'] ?? '');
    $num2 = trim($_POST['num2'] ?? '');
    $operation = $_POST['operation'] ?? '';
    
    // Validate input
    if (empty($num1) || empty($num2)) {
        $error = "Please enter both numbers.";
    } elseif (!is_numeric($num1) || !is_numeric($num2)) {
        $error = "Please enter valid numeric values.";
    } elseif (empty($operation)) {
        $error = "Please select an operation.";
    } else {
        // Convert to float for calculations
        $num1 = floatval($num1);
        $num2 = floatval($num2);
        
        // Perform calculation based on selected operation
        switch ($operation) {
            case 'add':
                $result = $num1 + $num2;
                break;
            case 'subtract':
                $result = $num1 - $num2;
                break;
            case 'multiply':
                $result = $num1 * $num2;
                break;
            case 'divide':
                if ($num2 == 0) {
                    $error = "Error: Division by zero is not allowed.";
                } else {
                    $result = $num1 / $num2;
                }
                break;
            default:
                $error = "Invalid operation selected.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color:rgb(180, 154, 154);
        }
        
        .calculator {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="number"]:focus, select:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        .operations {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .operation-btn {
            padding: 15px;
            border: 2px solid #ddd;
            background-color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .operation-btn:hover {
            background-color: #f0f0f0;
            border-color: #4CAF50;
        }
        
        .operation-btn.selected {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        
        .result.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .result.error {
            background-color: #f8d7da;
            color:rgb(98, 95, 95);
            border: 1px solid #f5c6cb;
        }
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Calculator</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="num1">First Number:</label>
                <input type="number" id="num1" name="num1" step="any" 
                       value="<?php echo htmlspecialchars($num1); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="num2">Second Number:</label>
                <input type="number" id="num2" name="num2" step="any" 
                       value="<?php echo htmlspecialchars($num2); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Select Operation:</label>
                <div class="operations">
                    <input type="radio" id="add" name="operation" value="add" 
                           <?php echo ($operation == 'add') ? 'checked' : ''; ?> class="hidden">
                    <label for="add" class="operation-btn <?php echo ($operation == 'add') ? 'selected' : ''; ?>">+</label>
                    
                    <input type="radio" id="subtract" name="operation" value="subtract" 
                           <?php echo ($operation == 'subtract') ? 'checked' : ''; ?> class="hidden">
                    <label for="subtract" class="operation-btn <?php echo ($operation == 'subtract') ? 'selected' : ''; ?>">−</label>
                    
                    <input type="radio" id="multiply" name="operation" value="multiply" 
                           <?php echo ($operation == 'multiply') ? 'checked' : ''; ?> class="hidden">
                    <label for="multiply" class="operation-btn <?php echo ($operation == 'multiply') ? 'selected' : ''; ?>">×</label>
                    
                    <input type="radio" id="divide" name="operation" value="divide" 
                           <?php echo ($operation == 'divide') ? 'checked' : ''; ?> class="hidden">
                    <label for="divide" class="operation-btn <?php echo ($operation == 'divide') ? 'selected' : ''; ?>">÷</label>
                </div>
            </div>
            
            <button type="submit">Calculate</button>
        </form>
        
        <?php if (!empty($result) && empty($error)): ?>
            <div class="result success">
                Result: <?php echo htmlspecialchars($result); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="result error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Add JavaScript for better user experience
        document.addEventListener('DOMContentLoaded', function() {
            const operationBtns = document.querySelectorAll('.operation-btn');
            
            operationBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove selected class from all buttons
                    operationBtns.forEach(b => b.classList.remove('selected'));
                    // Add selected class to clicked button
                    this.classList.add('selected');
                    // Check the corresponding radio button
                    const radio = this.previousElementSibling;
                    radio.checked = true;
                });
            });
        });
    </script>
</body>
</html>
