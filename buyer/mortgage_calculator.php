<?php
session_start();
include '../dbconnect.php';

require_once 'MortgageCalculatorController.php';

$controller = new MortgageCalculatorController();
$calculator = $controller->handleRequest();
$calculatorManager = $controller->getCalculatorManager();

function formatCurrency($amount)
{
    return '$' . number_format($amount, 2);
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
        <label for="property_name">Property Name:</label>
        <input type="text" id="property_name" name="property_name" required><br><br>
        <label for="loan_amount">Loan Amount:</label>
        <input type="number" id="loan_amount" name="loan_amount" step="0.01" required><br><br>
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

    <?php if ($calculator): ?>
        <h3>Monthly Repayment Details</h3>
        <table>
            <tr>
                <th>Property Name</th>
                <th>Loan Amount</th>
                <th>Interest Rate</th>
                <th>Loan Term</th>
                <th>Monthly Repayment</th>
                <th>Total Interest</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($_POST['property_name']); ?></td>
                <td><?php echo formatCurrency($calculator->getLoanAmount()); ?></td>
                <td><?php echo $calculator->getInterestRate(); ?>%</td>
                <td><?php echo floor($calculator->getLoanTermMonths() / 12); ?> Year<?php echo floor($calculator->getLoanTermMonths() / 12) !== 1 ? 's' : ''; ?>, <?php echo $calculator->getLoanTermMonths() % 12; ?> Month<?php echo $calculator->getLoanTermMonths() % 12 !== 1 ? 's' : ''; ?></td>
                <td><?php echo formatCurrency($calculator->getMonthlyRepayment()); ?></td>
                <td><?php echo formatCurrency($calculator->getTotalInterest()); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <h3>Saved Mortgage Calculations</h3>
    <?php $savedCalculations = $calculatorManager->getAllCalculations(); ?>
    <?php if (!empty($savedCalculations)): ?>
        <table>
            <tr>
                <th>Property Name</th>
                <th>Loan Amount</th>
                <th>Interest Rate</th>
                <th>Loan Term</th>
                <th>Monthly Repayment</th>
                <th>Total Interest</th>
            </tr>
            <?php foreach ($savedCalculations as $calculation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($calculation['property_name']); ?></td>
                    <td><?php echo formatCurrency($calculation['loan_amount']); ?></td>
                    <td><?php echo $calculation['interest_rate']; ?>%</td>
                    <td><?php echo floor($calculation['loan_term_months'] / 12); ?> Year<?php echo floor($calculation['loan_term_months'] / 12) !== 1 ? 's' : ''; ?>, <?php echo $calculation['loan_term_months'] % 12; ?> Month<?php echo $calculation['loan_term_months'] % 12 !== 1 ? 's' : ''; ?></td>
                    <td><?php echo formatCurrency($calculation['monthly_repayment']); ?></td>
                    <td><?php echo formatCurrency($calculation['total_interest']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No saved calculations.</p>
    <?php endif; ?>
</body>

</html>
