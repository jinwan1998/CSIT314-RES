<?php
require_once 'MortgageCalculatorController.php';

$calculatorManager = new MortgageCalculatorManager();

if (isset($_GET['calc'])){
    $calc = floatval($_GET['calc']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
    $loanAmount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0;
    $interestRate = isset($_POST['interest_rate']) ? floatval($_POST['interest_rate']) : 0;
    $years = isset($_POST['years']) ? intval($_POST['years']) : 0;
    $months = isset($_POST['months']) ? intval($_POST['months']) : 0;

    $loanTermMonths = $years * 12 + $months;

    if ($loanAmount > 0 && $interestRate > 0 && $loanTermMonths > 0) {
        // Create a new mortgage calculator instance
        $calculator = new MortgageCalculator($loanAmount, $interestRate, $loanTermMonths);
        // Add calculator to the manager with a unique property name
        $calculatorManager->addCalculator('Property', $calculator);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Calculator</title>
    <link rel="stylesheet" href="buyer.css">
</head>

<body>
    <h2>Mortgage Calculator</h2>
    <a href="buyer.php">Home</a>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="loan_amount">Loan Amount:</label>
        <input type="number" id="loan_amount" name="loan_amount" step="0.01" value="<?php echo $calc; ?>"><br><br>
        <label for="interest_rate">Interest Rate (% per annum):</label>
        <input type="number" id="interest_rate" name="interest_rate" step="0.01" required><br><br>
        <label for="loan_term">Loan Term:</label>
        <select name="years" id="years" required>
            <option value="" selected disabled>Select Years</option>
            <?php for ($i = 1; $i <= 30; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?> Year<?php echo $i !== 1 ? 's' : ''; ?></option>
            <?php endfor; ?>
        </select>
        <select name="months" id="months" required>
            <option value="" selected disabled>Select Months</option>
            <?php for ($j = 0; $j < 12; $j++): ?>
                <option value="<?php echo $j; ?>"><?php echo $j; ?> Month<?php echo $j !== 1 ? 's' : ''; ?></option>
            <?php endfor; ?>
        </select><br><br>
        <button type="submit" name="calculate">Calculate</button>
    </form>

    <?php if (!empty($calculatorManager->getCalculator('Property'))): ?>
        <h3>Monthly Repayment Details</h3>
        <table>
            <tr>
                <th>Loan Amount</th>
                <th>Interest Rate</th>
                <th>Loan Term</th>
                <th>Monthly Repayment</th>
                <th>Total Interest</th>
            </tr>
            <tr>
                <td><?php echo formatCurrency($loanAmount); ?></td>
                <td><?php echo $interestRate; ?>%</td>
                <td><?php echo $years; ?> Year<?php echo $years !== 1 ? 's' : ''; ?>, <?php echo $months; ?> Month<?php echo $months !== 1 ? 's' : ''; ?></td>
                <td><?php echo formatCurrency($calculatorManager->getCalculator('Property')->getMonthlyRepayment()); ?></td>
                <td><?php echo formatCurrency($calculatorManager->getCalculator('Property')->getTotalInterest()); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <?php
    function formatCurrency($amount)
    {
        return '$' . number_format($amount, 2);
    }
    ?>
</body>

</html>