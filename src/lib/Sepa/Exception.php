<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

/**
 * Extension of base exception to define SEPA related errors
 *
 * @author  ufozone
 * @since   2017-06-13
 * @uses \Exception
 */
class Exception extends \Exception
{
    const MESSAGE_ID_EMTPY = 1101;
    const MESSAGE_ID_INVALID = 1102;
    const INITIATOR_MISSING = 1200;
    const INITIATOR_EMPTY = 1201;
    const NO_TRANSACTIONS_PROVIDED = 1300;

    /**
     * Optional translation map shared by every Sepa\Exception (and subclass).
     * Format: [code => message template] — templates may contain {placeholder}
     * tokens that get filled from the exception's context.
     * @var array<int, string>
     */
    protected static array $translations = [];

    /**
     * @var array<string, mixed>
     */
    protected array $context = [];

    /**
     * @param string $message Default English message; may contain {placeholder} tokens.
     * @param int $code One of the SEPA exception code constants.
     * @param \Throwable|null $previous Previous exception for chaining.
     * @param array<string, mixed> $context Values for placeholder interpolation.
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null, array $context = [])
    {
        $this->context = $context;
        parent::__construct(self::interpolate($message, $context), $code, $previous);
    }

    /**
     * Configure translations for getLocalizedMessage().
     *
     * Accepts two input forms:
     *   - file path:   any string containing a directory separator or ending in ".php"
     *                  is treated as a file path and require()d
     *   - locale code: a bare code matching /^[A-Za-z]{2,3}(_[A-Za-z]{2,4})?$/
     *                  (e.g. "de", "de_DE", "pt_BR") loads the bundled file
     *                  src/lang/{locale}.php from this library
     *
     * SECURITY: setTranslations() executes the resolved file via require(). Do
     * NOT pass untrusted user input as a file path — that is a local file
     * inclusion vector. The locale form is safe to pass user input to: the
     * regex above rejects anything that could escape the bundled lang dir.
     *
     * Use clearTranslations() to reset.
     *
     * @param string $translations File path or bundled locale code.
     * @throws \InvalidArgumentException If the locale code is malformed, the file is missing, or it does not return an array.
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public static function setTranslations(string $translations) : void
    {
        $looksLikePath = (preg_match('#[/\\\\]|\.php$#', $translations) === 1);
        if ($looksLikePath)
        {
            $file = $translations;
        }
        else
        {
            if (preg_match('/^[A-Za-z]{2,3}(_[A-Za-z]{2,4})?$/', $translations) !== 1)
            {
                throw new \InvalidArgumentException('Invalid locale code: ' . $translations);
            }
            $file = __DIR__ . '/../../lang/' . $translations . '.php';
        }
        if (!is_file($file))
        {
            throw new \InvalidArgumentException('Translations file not found: ' . $file);
        }
        $loaded = require $file;
        if (!is_array($loaded))
        {
            throw new \InvalidArgumentException('Translations file did not return an array: ' . $file);
        }
        self::$translations = $loaded;
    }

    /**
     * Reset any previously registered translations. getLocalizedMessage() then
     * falls back to the English default for every code.
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public static function clearTranslations() : void
    {
        self::$translations = [];
    }

    /**
     * @return array<int, string>
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public static function getTranslations() : array
    {
        return self::$translations;
    }

    /**
     * @return array<string, mixed>
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public function getContext() : array
    {
        return $this->context;
    }

    /**
     * Return the message in the configured locale.
     *
     * If no translation is registered for this code, the English default from
     * getMessage() is returned unchanged. This keeps getMessage() stable for
     * logging while getLocalizedMessage() serves UI.
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    public function getLocalizedMessage() : string
    {
        if (isset(self::$translations[$this->code]))
        {
            return self::interpolate(self::$translations[$this->code], $this->context);
        }
        return $this->getMessage();
    }

    /**
     * Replace {key} tokens in $template with values from $context.
     * Non-scalar values are rendered as an empty string.
     *
     * @param array<string, mixed> $context
     *
     * @author  MichaelP08
     * @since   2026-05-11
     */
    private static function interpolate(string $template, array $context) : string
    {
        if (empty($context))
        {
            return $template;
        }
        $replacements = [];
        foreach ($context as $key => $value)
        {
            if (is_scalar($value) || $value === null)
            {
                $replacements['{' . $key . '}'] = (string) $value;
            }
            else
            {
                $replacements['{' . $key . '}'] = '';
            }
        }
        return strtr($template, $replacements);
    }
}
