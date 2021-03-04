<?php

/* @CoreHome/_periodSelect.twig */
class __TwigTemplate_040afb5c3ff52fae7901314575123f9b404c17c3cd8bad90749c327abc32847a extends Twig_Template
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
        echo "<div
    id=\"periodString\"
    piwik-period-selector
    periods=\"";
        // line 4
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["enabledPeriods"] ?? $this->getContext($context, "enabledPeriods"))), "html_attr");
        echo "\"
    class=\"borderedControl piwikTopControl\"
>
</div>
";
    }

    public function getTemplateName()
    {
        return "@CoreHome/_periodSelect.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div
    id=\"periodString\"
    piwik-period-selector
    periods=\"{{ enabledPeriods|json_encode|e('html_attr') }}\"
    class=\"borderedControl piwikTopControl\"
>
</div>
", "@CoreHome/_periodSelect.twig", "/var/www/html/plugins/CoreHome/templates/_periodSelect.twig");
    }
}
