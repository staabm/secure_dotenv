<?php

namespace staabm\SecureDotenv;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function file_get_contents;
use function strlen;

/**
 * @internal
 */
class ParserTest extends TestCase
{
    private $keyPath;
    private $envPath;

    protected function setUp(): void
    {
        $this->keyPath = __DIR__ . '/test-encryption-key.txt';
        $this->envPath = __DIR__ . '/.env';

        // Clear out the config
        file_put_contents($this->envPath, '');
    }

    public function testConstructor()
    {
        $parser = new Parser($this->keyPath, $this->envPath);
        static::assertInstanceOf(Parser::class, $parser);
    }

    public function testSetConfigPathWithInvalidPath()
    {
        $parser = new Parser($this->keyPath, $this->envPath);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid config file path: invalid_config_file');
        $parser->setConfigPath('invalid_config_file');
    }

    public function testSave()
    {
        $c = new Crypto(file_get_contents($this->keyPath));
        $parser = new Parser($this->keyPath, $this->envPath);
        $parser->setCrypto($c);

        static::assertTrue($parser->save('env1', 'test1234', true));

        $envContents = file_get_contents($this->envPath);
        static::assertStringStartsWith('env1=', $envContents);
        static::assertSame(190, strlen($envContents));
        static::assertStringEndsWith("\n", $envContents);
    }

    public function testLazyParsing()
    {
        $this->testSave();

        $parser = new Parser($this->keyPath, $this->envPath);
        $loadedValues = $parser->loadFile($this->envPath);

        foreach ($loadedValues as $loadedValue) {
            static::assertInstanceOf(LazySecret::class, $loadedValue);
            static::assertSame('test1234', (string) $loadedValue);
        }
    }

    public function testWriteEnvWithDuplicatedEnv()
    {
        $c = new Crypto(file_get_contents($this->keyPath));
        $parser = new Parser($this->keyPath, $this->envPath);
        $parser->setCrypto($c);

        $parser->save('env1', '123456', true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Key name "env1" already exists!');
        $parser->writeEnv('env1', 'overwrite_value1');
    }

    public function testReadWrite()
    {
        $content = 'test1234';

        $parser = new Parser($this->keyPath, $this->envPath);
        $parser->save('readwrite1', $content, true);

        // Now reparse the file
        $parser = new Parser($this->keyPath, $this->envPath);
        static::assertSame($content, (string) $parser->getContent('readwrite1'));
    }
}
