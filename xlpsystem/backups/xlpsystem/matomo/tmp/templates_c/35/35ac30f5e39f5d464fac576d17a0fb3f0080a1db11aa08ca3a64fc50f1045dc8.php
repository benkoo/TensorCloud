<?php

/* @CoreHome/_topBar.twig */
class __TwigTemplate_372942c7f34a6a6bae67424726853b773aa7be7e9b040b2f14673ed6ecd86a45 extends Twig_Template
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
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeTopBar", ($context["userAlias"] ?? $this->getContext($context, "userAlias")), ($context["userLogin"] ?? $this->getContext($context, "userLogin")), ($context["topMenu"] ?? $this->getContext($context, "topMenu"))));
        echo "
<ul class=\"right hide-on-med-and-down\">
    ";
        // line 10
        echo "
    ";
        // line 20
        echo "
    ";
        // line 22
        echo "
    ";
        // line 23
        if ( !array_key_exists("topMenuModule", $context)) {
            // line 24
            echo "        ";
            $context["topMenuModule"] = ($context["currentModule"] ?? $this->getContext($context, "currentModule"));
            // line 25
            echo "        ";
            $context["topMenuAction"] = ($context["currentAction"] ?? $this->getContext($context, "currentAction"));
            // line 26
            echo "    ";
        }
        // line 27
        echo "
    ";
        // line 28
        ob_start();
        // line 29
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["topMenu"] ?? $this->getContext($context, "topMenu")));
        foreach ($context['_seq'] as $context["label"] => $context["menu"]) {
            // line 30
            echo "            <li role=\"menuitem\" class=\"";
            echo $this->getAttribute($this, "isActiveItem", array(0 => $context["menu"], 1 => ($context["topMenuModule"] ?? $this->getContext($context, "topMenuModule")), 2 => ($context["topMenuAction"] ?? $this->getContext($context, "topMenuAction"))), "method");
            echo "\">";
            echo $this->getAttribute($this, "topMenuItem", array(0 => $context["label"], 1 => $this->getAttribute($context["menu"], "_icon", array()), 2 => $context["menu"]), "method");
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['label'], $context['menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "    ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 33
        echo "</ul>
<ul class=\"side-nav\" id=\"mobile-top-menu\">
    ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["topMenu"] ?? $this->getContext($context, "topMenu")));
        foreach ($context['_seq'] as $context["label"] => $context["menu"]) {
            // line 36
            echo "        <li role=\"menuitem\" class=\"";
            echo $this->getAttribute($this, "isActiveItem", array(0 => $context["menu"], 1 => ($context["topMenuModule"] ?? $this->getContext($context, "topMenuModule")), 2 => ($context["topMenuAction"] ?? $this->getContext($context, "topMenuAction"))), "method");
            echo "\"
            >";
            // line 37
            echo $this->getAttribute($this, "topMenuItem", array(0 => $context["label"], 1 => "", 2 => $context["menu"]), "method");
            echo "</li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['label'], $context['menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "</ul>
<a href=\"javascript:;\" data-activates=\"mobile-left-menu\" class=\"activateLeftMenu hide-on-large-only button-collapse\" style=\"display:none;\"><span class=\"icon-menu-hamburger\"></span></a>
<a href=\"javascript:;\" data-activates=\"mobile-top-menu\" class=\"activateTopMenu hide-on-large-only button-collapse\"><span class=\"icon-more-verti\"></span></a>
";
    }

    // line 3
    public function getmenuItemLabel($__label__ = null, $__icon__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "label" => $__label__,
            "icon" => $__icon__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 4
            echo "        ";
            if (((array_key_exists("icon", $context) && ($context["icon"] ?? $this->getContext($context, "icon"))) && (is_string($__internal_b25abd937057abfecb8f581ff65d30a552867e4104dfbd691c1ea3ee3b6d8c8c = ($context["icon"] ?? $this->getContext($context, "icon"))) && is_string($__internal_29f6747d500c2c6a5e4d9467d1e7caab1c6ae19a61d1d35ffdd6d364ddd76561 = "icon-") && ('' === $__internal_29f6747d500c2c6a5e4d9467d1e7caab1c6ae19a61d1d35ffdd6d364ddd76561 || 0 === strpos($__internal_b25abd937057abfecb8f581ff65d30a552867e4104dfbd691c1ea3ee3b6d8c8c, $__internal_29f6747d500c2c6a5e4d9467d1e7caab1c6ae19a61d1d35ffdd6d364ddd76561))))) {
                // line 5
                echo "            <span class=\"navbar-icon ";
                echo \Piwik\piwik_escape_filter($this->env, strip_tags(($context["icon"] ?? $this->getContext($context, "icon"))), "html", null, true);
                echo "\" aria-label=\"";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array(($context["label"] ?? $this->getContext($context, "label")))), "html_attr");
                echo "\"></span>
        ";
            } else {
                // line 7
                echo "            ";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array(($context["label"] ?? $this->getContext($context, "label")))), "html", null, true);
                echo "
        ";
            }
            // line 9
            echo "    ";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 11
    public function gettopMenuItem($__label__ = null, $__icon__ = null, $__menu__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "label" => $__label__,
            "icon" => $__icon__,
            "menu" => $__menu__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 12
            echo "        ";
            if ($this->getAttribute(($context["menu"] ?? null), "_html", array(), "any", true, true)) {
                // line 13
                echo "            ";
                echo $this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_html", array());
                echo "
        ";
            } else {
                // line 15
                echo "            <a ";
                if ($this->getAttribute(($context["menu"] ?? null), "_tooltip", array(), "any", true, true)) {
                    echo "title=\"";
                    echo \Piwik\piwik_escape_filter($this->env, $this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_tooltip", array()), "html", null, true);
                    echo "\"";
                }
                // line 16
                echo "               id=\"topmenu-";
                echo \Piwik\piwik_escape_filter($this->env, twig_lower_filter($this->env, $this->getAttribute($this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array()), "module", array())), "html", null, true);
                echo "\" target=\"_self\"
               href=\"index.php";
                // line 17
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('urlRewriteWithParameters')->getCallable(), array($this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array()))), "html", null, true);
                echo "\" tabindex=\"3\">";
                echo $this->getAttribute($this, "menuItemLabel", array(0 => ($context["label"] ?? $this->getContext($context, "label")), 1 => ($context["icon"] ?? $this->getContext($context, "icon"))), "method");
                echo "</a>
        ";
            }
            // line 19
            echo "    ";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 21
    public function getisActiveItem($__menu__ = null, $__currentModule__ = null, $__currentAction__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "menu" => $__menu__,
            "currentModule" => $__currentModule__,
            "currentAction" => $__currentAction__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            if ((((($context["menu"] ?? $this->getContext($context, "menu")) && $this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array())) && ($this->getAttribute($this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array()), "module", array()) == ($context["currentModule"] ?? $this->getContext($context, "currentModule")))) && (twig_test_empty($this->getAttribute($this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array()), "action", array())) || ($this->getAttribute($this->getAttribute(($context["menu"] ?? $this->getContext($context, "menu")), "_url", array()), "action", array()) == ($context["currentAction"] ?? $this->getContext($context, "currentAction")))))) {
                echo "active";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "@CoreHome/_topBar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  198 => 21,  183 => 19,  176 => 17,  171 => 16,  164 => 15,  158 => 13,  155 => 12,  141 => 11,  126 => 9,  120 => 7,  112 => 5,  109 => 4,  96 => 3,  89 => 39,  81 => 37,  76 => 36,  72 => 35,  68 => 33,  65 => 32,  54 => 30,  49 => 29,  47 => 28,  44 => 27,  41 => 26,  38 => 25,  35 => 24,  33 => 23,  30 => 22,  27 => 20,  24 => 10,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{ postEvent(\"Template.beforeTopBar\", userAlias, userLogin, topMenu) }}
<ul class=\"right hide-on-med-and-down\">
    {% macro menuItemLabel(label, icon) %}
        {% if icon is defined and icon and icon starts with 'icon-' %}
            <span class=\"navbar-icon {{ icon|striptags }}\" aria-label=\"{{ label|translate|e('html_attr') }}\"></span>
        {% else %}
            {{ label|translate }}
        {% endif %}
    {% endmacro %}

    {% macro topMenuItem(label, icon, menu) %}
        {% if menu._html is defined %}
            {{ menu._html|raw }}
        {% else %}
            <a {% if menu._tooltip is defined %}title=\"{{ menu._tooltip }}\"{% endif %}
               id=\"topmenu-{{ menu._url.module|lower }}\" target=\"_self\"
               href=\"index.php{{ menu._url|urlRewriteWithParameters }}\" tabindex=\"3\">{{ _self.menuItemLabel(label, icon) }}</a>
        {% endif %}
    {% endmacro %}

    {% macro isActiveItem(menu, currentModule, currentAction) %}{% if (menu and menu._url and menu._url.module == currentModule and (menu._url.action is empty or menu._url.action == currentAction)) %}active{% endif %}{% endmacro %}

    {% if topMenuModule is not defined %}
        {% set topMenuModule = currentModule %}
        {% set topMenuAction = currentAction %}
    {% endif %}

    {% spaceless %}
        {% for label,menu in topMenu %}
            <li role=\"menuitem\" class=\"{{ _self.isActiveItem(menu, topMenuModule, topMenuAction) }}\">{{ _self.topMenuItem(label, menu._icon, menu) }}</li>
        {% endfor %}
    {% endspaceless %}
</ul>
<ul class=\"side-nav\" id=\"mobile-top-menu\">
    {% for label,menu in topMenu %}
        <li role=\"menuitem\" class=\"{{ _self.isActiveItem(menu, topMenuModule, topMenuAction) }}\"
            >{{ _self.topMenuItem(label, '', menu) }}</li>
    {% endfor %}
</ul>
<a href=\"javascript:;\" data-activates=\"mobile-left-menu\" class=\"activateLeftMenu hide-on-large-only button-collapse\" style=\"display:none;\"><span class=\"icon-menu-hamburger\"></span></a>
<a href=\"javascript:;\" data-activates=\"mobile-top-menu\" class=\"activateTopMenu hide-on-large-only button-collapse\"><span class=\"icon-more-verti\"></span></a>
", "@CoreHome/_topBar.twig", "/var/www/html/plugins/CoreHome/templates/_topBar.twig");
    }
}
