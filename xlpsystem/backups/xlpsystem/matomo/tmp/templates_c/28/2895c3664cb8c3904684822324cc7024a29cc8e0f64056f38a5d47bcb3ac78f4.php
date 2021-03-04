<?php

/* @CoreVisualizations/_dataTableViz_jqplotGraph.twig */
class __TwigTemplate_1aec1cb10cb9c3c0dbb4c521499c433a90ddfb156011e216b53b151635fa5828 extends Twig_Template
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
        echo "<div alt=\"";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Mobile_StaticGraph")), "html", null, true);
        echo "\"  class=\"jqplot-graph\">
    <div class=\"piwik-graph\" data-data=\"";
        // line 2
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter($this->getAttribute(($context["visualization"] ?? $this->getContext($context, "visualization")), "getGraphData", array(0 => ($context["dataTable"] ?? $this->getContext($context, "dataTable")), 1 => ($context["properties"] ?? $this->getContext($context, "properties"))), "method")), "html", null, true);
        echo "\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@CoreVisualizations/_dataTableViz_jqplotGraph.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div alt=\"{{ 'Mobile_StaticGraph'|translate }}\"  class=\"jqplot-graph\">
    <div class=\"piwik-graph\" data-data=\"{{ visualization.getGraphData(dataTable, properties)|json_encode }}\"></div>
</div>
", "@CoreVisualizations/_dataTableViz_jqplotGraph.twig", "/var/www/html/plugins/CoreVisualizations/templates/_dataTableViz_jqplotGraph.twig");
    }
}
