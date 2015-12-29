<?php

namespace Crummy\Phlack\Common;

use Symfony\Component\OptionsResolver\OptionsResolver as BaseOptionsResolver;

class OptionsResolver extends BaseOptionsResolver
{
    private $isLatestVersion;

    /**
     * Set a list of allowed types for the given option.
     *
     * @see Symfony\Component\OptionsResolver\OptionsResolver::setAllowedTypes()
     *
     * @param array $allowedTypes
     *
     * @return $this
     */
    public function setTypesAllowed($allowedTypes = null)
    {
        if (!$this->isLatest()) {
            return $this->setAllowedTypes($allowedTypes);
        }

        foreach ($allowedTypes as $option => $typesAllowed) {
            $this->setAllowedTypes($option, $typesAllowed);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefined($optionNames)
    {
        if (!$this->isLatest()) {
            return $this->setOptional($optionNames);
        }

        return parent::setDefined($optionNames);
    }

    public function setNormalizers(array $normalizers)
    {
        if (!$this->isLatest()) {
            return parent::setNormalizers($normalizers);
        }

        foreach ($normalizers as $option => $normalizer) {
            parent::setNormalizer($option, $normalizer);
        }

        return $this;
    }

    /**
     * Checks whether or not the OptionsResolver version is up-to-date.
     *
     * @return bool
     */
    private function isLatest()
    {
        if (null === $this->isLatestVersion) {
            $this->isLatestVersion = method_exists(current(class_parents($this)), 'setDefined');
        }

        return $this->isLatestVersion;
    }
}
