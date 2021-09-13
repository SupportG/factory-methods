<?
    // === Products
    interface Product
    {
        public function getType(): string;
    }

    class Milk implements Product
    {
        public function getType(): string
        {
            return "Milk";
        }
    }

    class Coffee implements Product
    {
        public function getType(): string
        {
            return "Coffee";
        }
    }

    class Water implements Product
    {
        public function getType(): string
        {
            return "Water";
        }
    }

    // === Factories
    interface AbstractProductFactory
    {
        public function createProduct($type): Product;
    }

    class ProductFactory implements AbstractProductFactory
    {

        private array $factories;

        public function __construct($factories)
        {
            $this->factories = $factories;
        }

        public function createProduct($type): Product
        {

            if (!isset($this->factories[$type])) {
                throw new InvalidArgumentException();
            }

            return ($this->factories[$type])();
        }
    }

    class FactoryProductType
    {
        private $factory;

        public function __construct()
        {
            $this->factory = new ProductFactory([
                'coffee' => static function (): Product {
                    return new Coffee();
                },
                'milk' => static function (): Product {
                    return new Milk();
                },
                'water' => static function (): Product {
                    return new Water();
                },
            ]);
        }

        public function getProduct($type)
        {
            return $this->factory->createProduct($type);
        }
    }

    
    // === Program
    $type = 'coffee';
    $factory = new FactoryProductType();
    $product = $factory->getProduct($type);
    echo $product->getType();