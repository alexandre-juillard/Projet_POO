<?php

namespace App\Core;

abstract class Form
{
    protected string $formCode = '';

    public function startForm(string $action, string $method = 'POST', array $attributs = []): self
    {
        //ouvre balise form
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        //ajoute les autres attributs potentiels
        $this->formCode .= $attributs ? $this->addAttributs($attributs) . ">" : ">";

        return $this;
    }

    public function endForm(): self
    {
        $this->formCode .= "</form>";

        return $this;
    }

    public function startDiv(array $attributs = []): self
    {
        $this->formCode .= "<div";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    public function endDiv(): self
    {
        $this->formCode .= "</div>";

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for=\"$for\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs = []): self
    {
        $this->formCode .= "<input type=\"$type\" name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= "<button";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$text</button>";

        return $this;
    }

    public function addSelect(string $name, array $choices, array $attributs = []): self
    {
        $this->formCode .= "<select name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        foreach ($choices as $value => $info) {
            $this->formCode .= "<option value=\"$value\"";
            $this->formCode .= isset($info['attributs']) ? $this->addAttributs($info['attributs']) . '>' : '>';
            $this->formCode .= "$info[label]</option>";
        }

        $this->formCode .= "</select>";

        return $this;
    }

    public function addTextArea(string $name, ?string $value = null, array $attributs = [], int $rows = 10, int $cols = 20): self 
    {
        $this->formCode .= "<textarea name=\"$name\" rows=\"$rows\" cols=\"$cols\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$value</textarea>";

        return $this;
    }

    /**
     * ajoute attributs dans elements html
     * Tableau associatif exemple ['class' => 'form-control', 'id' => 'password']
     *
     * @param array $attributs
     * @return string
     */
    public function addAttributs(array $attributs): string
    {
        $str = "";

        $courts = ['checked', 'selected', 'required', 'disabled', 'multiple', 'readonly', 'novalidate', 'formnovalidate', 'wrap'];

        //boucle sur les attributs html du tableau
        foreach ($attributs as $name => $value) {
            if (in_array($name, $courts) && $value) {
                $str .= " $name";
            } else if ($value) {
                $str .= " $name=\"$value\"";
            }
        }


        return $str;
    }

    public function addImage(string $src, array $attributs = []): self 
    {
        $this->formCode .= "<img src=\"$src\"";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    public static function validate(array $champs, array $form): bool
    {
        //boucle sur tableau de champs obligatoires
        foreach ($champs as $champ) {
            if (!isset($form[$champ]) || empty($form[$champ]) || strlen(trim($form[$champ])) === 0) {
                return false;
            }
        }
        return true;
    }

    public function createForm(): string
    {
        return $this->formCode;
    }
}
