<?php

declare(strict_types=1);

namespace Jfcherng\Diff\Renderer\Html;

use Jfcherng\Diff\SequenceMatcher;

/**
 * Json diff generator.
 */
final class Json extends AbstractHtml
{
    /**
     * {@inheritdoc}
     */
    const INFO = [
        'desc' => 'Json',
    ];

    /**
     * {@inheritdoc}
     */
    const IS_TEXT_TEMPLATE = true;

    /**
     * {@inheritdoc}
     */
    public function render(): string
    {
        $changes = $this->getChanges();

        if (empty($changes)) {
            return self::getIdenticalResult();
        }

        if ($this->options['outputTagAsString']) {
            $this->convertTagToString($changes);
        }

        return \json_encode(
            $changes,
            \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getIdenticalResult(): string
    {
        return '[]';
    }

    /**
     * Convert tags of changes to their string form for better readability.
     *
     * @param array $changes the changes
     */
    protected function convertTagToString(array &$changes): void
    {
        foreach ($changes as &$blocks) {
            foreach ($blocks as &$change) {
                $change['tag'] = SequenceMatcher::opIntToStr($change['tag']);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function formatStringFromLines(string $string): string
    {
        return $this->htmlSafe($string);
    }
}
