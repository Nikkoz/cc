<?php

/* table/browse_foreigners/column_element.twig */
class __TwigTemplate_6a608394b996de3de5538781b0252cb0727963fb0b3563837a23ccf5516ee10c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<td";
        echo ((($context["nowrap"] ?? null)) ? (" class=\"nowrap\"") : (""));
        echo ">
    ";
        // line 2
        echo ((($context["is_selected"] ?? null)) ? ("<strong>") : (""));
        echo "
        <a class=\"foreign_value\" data-key=\"";
        // line 3
        echo twig_escape_filter($this->env, ($context["keyname"] ?? null), "html", null, true);
        echo "\" href=\"#\" title=\"";
        // line 4
        echo _gettext("Use this value");
        echo twig_escape_filter($this->env, (( !twig_test_empty(($context["title"] ?? null))) ? ((": " . ($context["title"] ?? null))) : ("")), "html", null, true);
        echo "\">
            ";
        // line 5
        if (($context["nowrap"] ?? null)) {
            // line 6
            echo "                ";
            echo twig_escape_filter($this->env, ($context["keyname"] ?? null), "html", null, true);
            echo "
            ";
        } else {
            // line 8
            echo "                ";
            echo twig_escape_filter($this->env, ($context["description"] ?? null), "html", null, true);
            echo "
            ";
        }
        // line 10
        echo "        </a>
    ";
        // line 11
        echo ((($context["is_selected"] ?? null)) ? ("</strong>") : (""));
        echo "
</td>
";
    }

    public function getTemplateName()
    {
        return "table/browse_foreigners/column_element.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 11,  50 => 10,  44 => 8,  38 => 6,  36 => 5,  31 => 4,  28 => 3,  24 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "table/browse_foreigners/column_element.twig", "/app/frontend/web/pma/templates/table/browse_foreigners/column_element.twig");
    }
}
