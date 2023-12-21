<?php

namespace App\Core;

class Form
{
    protected string $formCode = '';

    /**
     * Valide un formulaire
     *
     * @param array $form - $_POST (le formulaire soumis)
     * @param array $champs - Les champs obligatoires
     * @return boolean
     */
    public static function validate(array $form, array $champs): bool
    {
        foreach ($champs as $champ) {
            if (
                !isset($form[$champ])
                || empty($form[$champ])
                || strlen(trim($form[$champ])) === 0
            ) {
                return false;
            }
        }

        return true;
    }

    public function startForm(string $method = "POST", string $action = "#", array $attributs = []): self
    {
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // On ajoute les attributs HTML éventuels
        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    public function endForm(): self
    {
        $this->formCode .= "</form>";

        return $this;
    }

    public  function startDiv(array $attributs = []): self
    {
        $this->formCode .= "<div";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    public function endDiv(): self
    {
        $this->formCode .= '</div>';

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for=\"$for\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$text</label>";

        return $this;
    }

    public function addInput(string $name, string $type, array $attributs = []): self
    {
        $this->formCode .= "<input type=\"$type\" name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '/>' : '/>';

        return $this;
    }

    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= "<button";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$text</button>";

        return $this;
    }

    public function addTextarea(string $name, string $value = '', array $attributs = []): self
    {
        $this->formCode .= "<textarea name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$value</textarea>";

        return $this;
    }

    public function addSelect(string $name, array $options, array $attributs = []): self
    {
        $this->formCode .= "<select name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        foreach ($options as $value => $option) {
            $this->formCode .= "<option value=\"$value\"";

            $this->formCode .= isset($option['attributs']) ? $this->addAttributs($options['attributs']) . '>' : '>';

            $this->formCode  .= "$option[label]</option>";
        }

        $this->formCode .= "</select>";

        return $this;
    }

    /**
     * Ajoute les attributs envoyés à la balise html
     *
     * @param array $attributs Tableau associatif (['class' => 'form-control', 'require' =>  true])
     * @return string
     */
    public function addAttributs(array $attributs): string
    {
        // On initialiser un string vide
        $str = '';

        // On définit les attributs courts
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // On boucle le tableau d'attribut
        foreach ($attributs as $key => $value) {
            if (in_array($key, $courts) && $value) {
                $str .= " $key";
            } else {
                $str .= " $key=\"$value\"";
            }
        }

        return $str;
    }

    /**
     * Retourne le code HTML du formulaire dans un string
     *
     * @return string
     */
    public function createForm(): string
    {
        return $this->formCode;
    }
}
