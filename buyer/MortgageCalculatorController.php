<?php
class MortgageCalculatorController
{
    private $calculatorManager;

    public function __construct()
    {
        $this->calculatorManager = new MortgageCalculatorManager();
    }

    public function handleRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
            return $this->processForm();
        }
        return null;
    }

    private function processForm()
    {
        try {
            $propertyName = isset($_POST['property_name']) ? $_POST['property_name'] : '';
            $loanAmount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0;
            $interestRate = isset($_POST['interest_rate']) ? floatval($_POST['interest_rate']) : 0;
            $years = isset($_POST['years']) ? intval($_POST['years']) : 0;
            $months = isset($_POST['months']) ? intval($_POST['months']) : 0;

            $loanTermMonths = $years * 12 + $months;

            if ($propertyName && $loanAmount > 0 && $interestRate > 0 && $loanTermMonths > 0) {
                $calculator = new MortgageCalculator($loanAmount, $interestRate, $loanTermMonths);
                $this->calculatorManager->addCalculator($propertyName, $calculator);
                $this->calculatorManager->saveCalculations();  // Save the calculations
                return $calculator;
            } else {
                throw new Exception("All input fields are required and must be greater than zero.");
            }
        } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        return null;
    }

    public function getCalculatorManager()
    {
        return $this->calculatorManager;
    }
}

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

    public function getLoanAmount()
    {
        return $this->loanAmount;
    }

    public function getInterestRate()
    {
        return $this->interestRate;
    }

    public function getLoanTermMonths()
    {
        return $this->loanTermMonths;
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
        $calculations = [];
        foreach ($this->calculators as $propertyName => $calculator) {
            $calculations[$propertyName] = [
                'monthly_repayment' => $calculator->getMonthlyRepayment(),
                'total_interest' => $calculator->getTotalInterest()
            ];
        }
        return $calculations;
    }

    public function saveCalculations()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "username", "password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO mortgage_calculations (property_name, monthly_repayment, total_interest) VALUES (?, ?, ?)");

            foreach ($this->calculators as $propertyName => $calculator) {
                $stmt->execute([
                    $propertyName,
                    $calculator->getMonthlyRepayment(),
                    $calculator->getTotalInterest()
                ]);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
