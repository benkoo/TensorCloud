<?php

/* @CoreHome\_uiControl.twig */
class __TwigTemplate_783d8ce41e8151410e55a10481ed8ace4aa720d896fb62ea5b7b52539399286a extends Twig_Template
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
        echo "<div class=\"";
        echo \Piwik\piwik_escape_filter($this->env, ($context["cssIdentifier"] ?? $this->getContext($context, "cssIdentifier")), "html", null, true);
        echo " ";
        echo \Piwik\piwik_escape_filter($this->env, ($context["cssClass"] ?? $this->getContext($context, "cssClass")), "html", null, true);
        echo "\"
    ";
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["htmlAttributes"] ?? $this->getContext($context, "htmlAttributes")));
        foreach ($context['_seq'] as $context["name"] => $context["value"]) {
            // line 3
            echo "         ";
            echo \Piwik\piwik_escape_filter($this->env, $context["name"], "html", null, true);
            echo "=\"";
            echo \Piwik\piwik_escape_filter($this->env, $context["value"], "html_attr");
            echo "\"
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 5
        echo "    data-props=\"";
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["clientSideProperties"] ?? $this->getContext($context, "clientSideProperties"))), "html", null, true);
        echo "\"
    data-params=\"";
        // line 6
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["clientSideParameters"] ?? $this->getContext($context, "clientSideParameters"))), "html", null, true);
        echo "\">
";
        // line 7
        $this->loadTemplate($context["implView"]->getTemplateFile(), "@CoreHome\\_uiControl.twig", 7)->display(array_merge($context, $context["implView"]->getTemplateVars(($context["implOverride"] ?? $this->getContext($context, "implOverride")))));
        // line 8
        echo "</div>
<script>\$(document).ready(function () { require('";
        // line 9
        echo \Piwik\piwik_escape_filter($this->env, ($context["jsNamespace"] ?? $this->getContext($context, "jsNamespace")), "html", null, true);
        echo "').";
        echo \Piwik\piwik_escape_filter($this->env, ($context["jsClass"] ?? $this->getContext($context, "jsClass")), "html", null, true);
        echo ".initElements(); });</script>";
    }

    public function getTemplateName()
    {
        return "@CoreHome\\_uiControl.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 9,  52 => 8,  50 => 7,  46 => 6,  41 => 5,  30 => 3,  26 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"{{ cssIdentifier }} {{ cssClass }}\"
    {% for name,value in htmlAttributes %}
         {{ name }}=\"{{ value|e('html_attr') }}\"
    {% endfor %}
    data-props=\"{{ clientSideProperties|json_encode }}\"
    data-params=\"{{ clientSideParameters|json_encode }}\">
{% render implView with implOverride %}
</div>
<script>\$(document).ready(function () { require('{{ jsNamespace }}').{{ jsClass }}.initElements(); });</script>", "@CoreHome\\_uiControl.twig", "/var/www/html/plugins/CoreHome/templates/_uiControl.twig");
    }
}
