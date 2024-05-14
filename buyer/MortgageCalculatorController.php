<?php
class MortgageCalculator
{
    private $loanAmount;
    private $interestRate;
    private $loanTermMonths;
    private $monthlyRepayment;
    private $totalInterest;

    public function __construct($loanAmount = 0, $interestRate = 0, $loanTermMonths = 0)
    {
        $this->loanAmount = $loanAmount;
        $this->interestRate = $interestRate;
        $this->loanTermMonths = $loanTermMonths;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setLoanAmount($loanAmount)
    {
        $this->loanAmount = $loanAmount;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function setLoanTermMonths($loanTermMonths)
    {
        $this->loanTermMonths = $loanTermMonths;
        $this->calculateMonthlyRepayment();
        $this->calculateTotalInterest();
    }

    public function getMonthlyRepayment()
    {
        return $this->monthlyRepayment;
    }

    public function getTotalInterest()
    {
        return $this->totalInterest;
    }

    private function calculateMonthlyRepayment()
    {
        $monthlyInterestRate = ($this->interestRate / 100) / 12;
        $numerator = $this->loanAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $this->loanTermMonths);
        $denominator = pow(1 + $monthlyInterestRate, $this->loanTermMonths) - 1;
        $this->monthlyRepayment = $numerator / $denominator;
    }

    private function calculateTotalInterest()
    {
        $this->totalInterest = $this->monthlyRepayment * $this->loanTermMonths - $this->loanAmount;
    }
}

class MortgageCalculatorManager
{
    private $calculators = [];

    public function addCalculator($propertyName, MortgageCalculator $calculator)
    {
        $this->calculators[$propertyName] = $calculator;
    }

    public function getCalculator($propertyName)
    {
        return $this->calculators[$propertyName] ?? null;
    }

    public function removeCalculator($propertyName)
    {
        unset($this->calculators[$propertyName]);
    }

    public function compareCalculations()
{
    // This method can be used to compare calculations for different properties
    // For example, you can compare monthly repayments or total interest paid for each property
    // You can implement any comparison logic here based on your requirements

    $calculations = [];
    foreach ($this->calculators as $propertyName => $calculator) {
        $calculations[$propertyName] = [
            'monthly_repayment' => $calculator->getMonthlyRepayment(),
            'total_interest' => $calculator->getTotalInterest()
        ];
    }

    // Implement comparison logic here
    // For example, you can compare the calculations and display the results

    return $calculations;
}

public function saveCalculations()
{
    // This method can be used to save mortgage calculations for different properties
    // You can save the calculations to a database, file, or any other storage mechanism

    // Implement the saving logic here
    // For example, you can save the calculations to a database

    // Connect to database
    $pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "username", "password");

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO mortgage_calculations (property_name, monthly_repayment, total_interest) VALUES (?, ?, ?)");

    // Iterate over calculators and save calculations to database
    foreach ($this->calculators as $propertyName => $calculator) {
        // Bind parameters
        $stmt->bindParam(1, $propertyName);
        $stmt->bindParam(2, $calculator->getMonthlyRepayment());
        $stmt->bindParam(3, $calculator->getTotalInterest());

        // Execute SQL statement
        $stmt->execute();
    }

    // Close database connection
    $pdo = null;
}

}
?>