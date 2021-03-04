<?php

/* @Login/login.twig */
class __TwigTemplate_1d2e1574e9d3f539b0abd9f02e3a4aed1e5ee8e9b922afd8b9a68fb774d7d868 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Morpheus/layout.twig", "@Login/login.twig", 1);
        $this->blocks = array(
            'meta' => array($this, 'block_meta'),
            'head' => array($this, 'block_head'),
            'pageDescription' => array($this, 'block_pageDescription'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Morpheus/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 13
        ob_start();
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LogIn")), "html", null, true);
        $context["title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 17
        $context["bodyId"] = "loginPage";
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_meta($context, array $blocks = array())
    {
        // line 4
        echo "    <meta name=\"robots\" content=\"index,follow\">
";
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "

    <script type=\"text/javascript\" src=\"libs/bower_components/jquery-placeholder/jquery.placeholder.js\"></script>
";
    }

    // line 15
    public function block_pageDescription($context, array $blocks = array())
    {
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_OpenSourceWebAnalytics")), "html", null, true);
    }

    // line 19
    public function block_body($context, array $blocks = array())
    {
        // line 20
        echo "
    ";
        // line 21
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeTopBar", "login"));
        echo "
    ";
        // line 22
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeContent", "login"));
        echo "

    ";
        // line 24
        $this->loadTemplate("_iframeBuster.twig", "@Login/login.twig", 24)->display($context);
        // line 25
        echo "
    <div id=\"notificationContainer\">
    </div>
    <nav class=\"blue-grey darken-3\">
        <div class=\"nav-wrapper\">
            <span id=\"logo\" class=\"brand-logo center\">

                ";
        // line 32
        if ((($context["isCustomLogo"] ?? $this->getContext($context, "isCustomLogo")) == false)) {
            // line 33
            echo "                    <a href=\"https://matomo.org\" title=\"";
            echo \Piwik\piwik_escape_filter($this->env, ($context["linkTitle"] ?? $this->getContext($context, "linkTitle")), "html", null, true);
            echo "\">
                ";
        }
        // line 35
        echo "                ";
        if (($context["hasSVGLogo"] ?? $this->getContext($context, "hasSVGLogo"))) {
            // line 36
            echo "                    <img src='";
            echo \Piwik\piwik_escape_filter($this->env, ($context["logoSVG"] ?? $this->getContext($context, "logoSVG")), "html", null, true);
            echo "' class=\"";
            if ( !($context["isCustomLogo"] ?? $this->getContext($context, "isCustomLogo"))) {
                echo "default-piwik-logo";
            }
            echo "\" title=\"";
            echo \Piwik\piwik_escape_filter($this->env, ($context["linkTitle"] ?? $this->getContext($context, "linkTitle")), "html", null, true);
            echo "\" alt=\"Matomo\"/>
                ";
        } else {
            // line 38
            echo "                    <img src='";
            echo \Piwik\piwik_escape_filter($this->env, ($context["logoLarge"] ?? $this->getContext($context, "logoLarge")), "html", null, true);
            echo "' title=\"";
            echo \Piwik\piwik_escape_filter($this->env, ($context["linkTitle"] ?? $this->getContext($context, "linkTitle")), "html", null, true);
            echo "\" alt=\"Matomo\" />
                ";
        }
        // line 40
        echo "
                ";
        // line 41
        if ((($context["isCustomLogo"] ?? $this->getContext($context, "isCustomLogo")) == false)) {
            // line 42
            echo "                    </a>
                ";
        }
        // line 44
        echo "
            </span>
        </div>
    </nav>

    <section class=\"loginSection row\">
        <div class=\"col s12 m6 push-m3 l4 push-l4\">

        ";
        // line 53
        echo "        ";
        if (((array_key_exists("isValidHost", $context) && array_key_exists("invalidHostMessage", $context)) && (($context["isValidHost"] ?? $this->getContext($context, "isValidHost")) == false))) {
            // line 54
            echo "            ";
            $this->loadTemplate("@CoreHome/_warningInvalidHost.twig", "@Login/login.twig", 54)->display($context);
            // line 55
            echo "        ";
        } else {
            // line 56
            echo "            <div class=\"contentForm loginForm\">
                ";
            // line 57
            $this->loadTemplate("@Login/login.twig", "@Login/login.twig", 57, "564920842")->display(array_merge($context, array("title" => call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LogIn")))));
            // line 123
            echo "            </div>
            <div class=\"contentForm resetForm\" style=\"display:none;\">
                ";
            // line 125
            $this->loadTemplate("@Login/login.twig", "@Login/login.twig", 125, "1195809440")->display(array_merge($context, array("title" => call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_ChangeYourPassword")))));
            // line 180
            echo "            </div>
        ";
        }
        // line 182
        echo "
    </section>

";
    }

    public function getTemplateName()
    {
        return "@Login/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  164 => 182,  160 => 180,  158 => 125,  154 => 123,  152 => 57,  149 => 56,  146 => 55,  143 => 54,  140 => 53,  130 => 44,  126 => 42,  124 => 41,  121 => 40,  113 => 38,  101 => 36,  98 => 35,  92 => 33,  90 => 32,  81 => 25,  79 => 24,  74 => 22,  70 => 21,  67 => 20,  64 => 19,  58 => 15,  49 => 8,  46 => 7,  41 => 4,  38 => 3,  34 => 1,  32 => 17,  28 => 13,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Morpheus/layout.twig' %}

{% block meta %}
    <meta name=\"robots\" content=\"index,follow\">
{% endblock %}

{% block head %}
    {{ parent() }}

    <script type=\"text/javascript\" src=\"libs/bower_components/jquery-placeholder/jquery.placeholder.js\"></script>
{% endblock %}

{% set title %}{{ 'Login_LogIn'|translate }}{% endset %}

{% block pageDescription %}{{ 'General_OpenSourceWebAnalytics'|translate }}{% endblock %}

{% set bodyId = 'loginPage' %}

{% block body %}

    {{ postEvent(\"Template.beforeTopBar\", \"login\") }}
    {{ postEvent(\"Template.beforeContent\", \"login\") }}

    {% include \"_iframeBuster.twig\" %}

    <div id=\"notificationContainer\">
    </div>
    <nav class=\"blue-grey darken-3\">
        <div class=\"nav-wrapper\">
            <span id=\"logo\" class=\"brand-logo center\">

                {% if isCustomLogo == false %}
                    <a href=\"https://matomo.org\" title=\"{{ linkTitle }}\">
                {% endif %}
                {% if hasSVGLogo %}
                    <img src='{{ logoSVG }}' class=\"{% if not isCustomLogo %}default-piwik-logo{% endif %}\" title=\"{{ linkTitle }}\" alt=\"Matomo\"/>
                {% else %}
                    <img src='{{ logoLarge }}' title=\"{{ linkTitle }}\" alt=\"Matomo\" />
                {% endif %}

                {% if isCustomLogo == false %}
                    </a>
                {% endif %}

            </span>
        </div>
    </nav>

    <section class=\"loginSection row\">
        <div class=\"col s12 m6 push-m3 l4 push-l4\">

        {# untrusted host warning #}
        {% if (isValidHost is defined and invalidHostMessage is defined and isValidHost == false) %}
            {% include '@CoreHome/_warningInvalidHost.twig' %}
        {% else %}
            <div class=\"contentForm loginForm\">
                {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
                {% block content %}

                    <div class=\"message_container\">

                        {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                        {% if AccessErrorString %}
                            <div piwik-notification
                                 noclear=\"true\"
                                 context=\"error\">
                                <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                            </div>
                        {% endif %}

                        {% if infoMessage %}
                            <p class=\"message\">{{ infoMessage|raw }}</p>
                        {% endif %}
                    </div>

                    <form {{ form_data.attributes|raw }} ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"text\" name=\"form_login\" placeholder=\"\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\" autofocus=\"autofocus\"/>
                                <label for=\"login_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"login_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" />
                                <label for=\"login_form_password\"><i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\" tabindex=\"90\"
                                       {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                <label for=\"login_form_rememberme\">{{ 'Login_RememberMe'|translate }}</label>
                                <input class=\"submit btn\" id='login_form_submit' type=\"submit\" value=\"{{ 'Login_LogIn'|translate }}\"
                                       tabindex=\"100\"/>
                            </div>
                        </div>

                    </form>
                    <p id=\"nav\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        <a id=\"login_form_nav\" href=\"#\"
                           title=\"{{ 'Login_LostYourPassword'|translate }}\">{{ 'Login_LostYourPassword'|translate }}</a>
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </p>

                    {% if isCustomLogo %}
                        <p id=\"piwik\">
                            <i><a href=\"https://matomo.org/\" rel=\"noreferrer\"  target=\"_blank\">{{ linkTitle }}</a></i>
                        </p>
                    {% endif %}

                {% endblock %}
                {% endembed %}
            </div>
            <div class=\"contentForm resetForm\" style=\"display:none;\">
                {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
                {% block content %}

                    <div class=\"message_container\">
                    </div>

                    <form id=\"reset_form\" method=\"post\" ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\"/>
                                <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       size=\"20\" tabindex=\"30\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input class=\"submit btn\" id='reset_form_submit' type=\"submit\"
                                       value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                <span class=\"loadingPiwik\" style=\"display:none;\">
                                    <img alt=\"Loading\" src=\"plugins/Morpheus/images/loading-blue.gif\"/>
                                </span>
                            </div>
                        </div>

                        <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                        <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                    </form>
                    <p id=\"nav\">
                        <a id=\"reset_form_nav\" href=\"#\"
                           title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                        <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                           title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                    </p>
                {% endblock %}
                {% endembed %}
            </div>
        {% endif %}

    </section>

{% endblock %}
", "@Login/login.twig", "/var/www/html/plugins/Login/templates/login.twig");
    }
}


/* @Login/login.twig */
class __TwigTemplate_1d2e1574e9d3f539b0abd9f02e3a4aed1e5ee8e9b922afd8b9a68fb774d7d868_564920842 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 57
        $this->parent = $this->loadTemplate("contentBlock.twig", "@Login/login.twig", 57);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "contentBlock.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 58
    public function block_content($context, array $blocks = array())
    {
        // line 59
        echo "
                    <div class=\"message_container\">

                        ";
        // line 62
        echo twig_include($this->env, $context, "@Login/_formErrors.twig", array("formErrors" => $this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "errors", array())));
        echo "

                        ";
        // line 64
        if (($context["AccessErrorString"] ?? $this->getContext($context, "AccessErrorString"))) {
            // line 65
            echo "                            <div piwik-notification
                                 noclear=\"true\"
                                 context=\"error\">
                                <strong>";
            // line 68
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
            echo "</strong>: ";
            echo ($context["AccessErrorString"] ?? $this->getContext($context, "AccessErrorString"));
            echo "<br/>
                            </div>
                        ";
        }
        // line 71
        echo "
                        ";
        // line 72
        if (($context["infoMessage"] ?? $this->getContext($context, "infoMessage"))) {
            // line 73
            echo "                            <p class=\"message\">";
            echo ($context["infoMessage"] ?? $this->getContext($context, "infoMessage"));
            echo "</p>
                        ";
        }
        // line 75
        echo "                    </div>

                    <form ";
        // line 77
        echo $this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "attributes", array());
        echo " ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"text\" name=\"form_login\" placeholder=\"\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\" autofocus=\"autofocus\"/>
                                <label for=\"login_form_login\"><i class=\"icon-user icon\"></i> ";
        // line 83
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LoginOrEmail")), "html", null, true);
        echo "</label>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"";
        // line 89
        echo \Piwik\piwik_escape_filter($this->env, ($context["nonce"] ?? $this->getContext($context, "nonce")), "html", null, true);
        echo "\"/>
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"login_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" />
                                <label for=\"login_form_password\"><i class=\"icon-locked icon\"></i> ";
        // line 93
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Password")), "html", null, true);
        echo "</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\" tabindex=\"90\"
                                       ";
        // line 100
        if ($this->getAttribute($this->getAttribute(($context["form_data"] ?? $this->getContext($context, "form_data")), "form_rememberme", array()), "value", array())) {
            echo "checked=\"checked\" ";
        }
        echo "/>
                                <label for=\"login_form_rememberme\">";
        // line 101
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_RememberMe")), "html", null, true);
        echo "</label>
                                <input class=\"submit btn\" id='login_form_submit' type=\"submit\" value=\"";
        // line 102
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LogIn")), "html", null, true);
        echo "\"
                                       tabindex=\"100\"/>
                            </div>
                        </div>

                    </form>
                    <p id=\"nav\">
                        ";
        // line 109
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.loginNav", "top"));
        echo "
                        <a id=\"login_form_nav\" href=\"#\"
                           title=\"";
        // line 111
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LostYourPassword")), "html", null, true);
        echo "\">";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LostYourPassword")), "html", null, true);
        echo "</a>
                        ";
        // line 112
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.loginNav", "bottom"));
        echo "
                    </p>

                    ";
        // line 115
        if (($context["isCustomLogo"] ?? $this->getContext($context, "isCustomLogo"))) {
            // line 116
            echo "                        <p id=\"piwik\">
                            <i><a href=\"https://matomo.org/\" rel=\"noreferrer\"  target=\"_blank\">";
            // line 117
            echo \Piwik\piwik_escape_filter($this->env, ($context["linkTitle"] ?? $this->getContext($context, "linkTitle")), "html", null, true);
            echo "</a></i>
                        </p>
                    ";
        }
        // line 120
        echo "
                ";
    }

    public function getTemplateName()
    {
        return "@Login/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  536 => 120,  530 => 117,  527 => 116,  525 => 115,  519 => 112,  513 => 111,  508 => 109,  498 => 102,  494 => 101,  488 => 100,  478 => 93,  471 => 89,  462 => 83,  453 => 77,  449 => 75,  443 => 73,  441 => 72,  438 => 71,  430 => 68,  425 => 65,  423 => 64,  418 => 62,  413 => 59,  410 => 58,  393 => 57,  164 => 182,  160 => 180,  158 => 125,  154 => 123,  152 => 57,  149 => 56,  146 => 55,  143 => 54,  140 => 53,  130 => 44,  126 => 42,  124 => 41,  121 => 40,  113 => 38,  101 => 36,  98 => 35,  92 => 33,  90 => 32,  81 => 25,  79 => 24,  74 => 22,  70 => 21,  67 => 20,  64 => 19,  58 => 15,  49 => 8,  46 => 7,  41 => 4,  38 => 3,  34 => 1,  32 => 17,  28 => 13,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Morpheus/layout.twig' %}

{% block meta %}
    <meta name=\"robots\" content=\"index,follow\">
{% endblock %}

{% block head %}
    {{ parent() }}

    <script type=\"text/javascript\" src=\"libs/bower_components/jquery-placeholder/jquery.placeholder.js\"></script>
{% endblock %}

{% set title %}{{ 'Login_LogIn'|translate }}{% endset %}

{% block pageDescription %}{{ 'General_OpenSourceWebAnalytics'|translate }}{% endblock %}

{% set bodyId = 'loginPage' %}

{% block body %}

    {{ postEvent(\"Template.beforeTopBar\", \"login\") }}
    {{ postEvent(\"Template.beforeContent\", \"login\") }}

    {% include \"_iframeBuster.twig\" %}

    <div id=\"notificationContainer\">
    </div>
    <nav class=\"blue-grey darken-3\">
        <div class=\"nav-wrapper\">
            <span id=\"logo\" class=\"brand-logo center\">

                {% if isCustomLogo == false %}
                    <a href=\"https://matomo.org\" title=\"{{ linkTitle }}\">
                {% endif %}
                {% if hasSVGLogo %}
                    <img src='{{ logoSVG }}' class=\"{% if not isCustomLogo %}default-piwik-logo{% endif %}\" title=\"{{ linkTitle }}\" alt=\"Matomo\"/>
                {% else %}
                    <img src='{{ logoLarge }}' title=\"{{ linkTitle }}\" alt=\"Matomo\" />
                {% endif %}

                {% if isCustomLogo == false %}
                    </a>
                {% endif %}

            </span>
        </div>
    </nav>

    <section class=\"loginSection row\">
        <div class=\"col s12 m6 push-m3 l4 push-l4\">

        {# untrusted host warning #}
        {% if (isValidHost is defined and invalidHostMessage is defined and isValidHost == false) %}
            {% include '@CoreHome/_warningInvalidHost.twig' %}
        {% else %}
            <div class=\"contentForm loginForm\">
                {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
                {% block content %}

                    <div class=\"message_container\">

                        {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                        {% if AccessErrorString %}
                            <div piwik-notification
                                 noclear=\"true\"
                                 context=\"error\">
                                <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                            </div>
                        {% endif %}

                        {% if infoMessage %}
                            <p class=\"message\">{{ infoMessage|raw }}</p>
                        {% endif %}
                    </div>

                    <form {{ form_data.attributes|raw }} ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"text\" name=\"form_login\" placeholder=\"\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\" autofocus=\"autofocus\"/>
                                <label for=\"login_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"login_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" />
                                <label for=\"login_form_password\"><i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\" tabindex=\"90\"
                                       {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                <label for=\"login_form_rememberme\">{{ 'Login_RememberMe'|translate }}</label>
                                <input class=\"submit btn\" id='login_form_submit' type=\"submit\" value=\"{{ 'Login_LogIn'|translate }}\"
                                       tabindex=\"100\"/>
                            </div>
                        </div>

                    </form>
                    <p id=\"nav\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        <a id=\"login_form_nav\" href=\"#\"
                           title=\"{{ 'Login_LostYourPassword'|translate }}\">{{ 'Login_LostYourPassword'|translate }}</a>
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </p>

                    {% if isCustomLogo %}
                        <p id=\"piwik\">
                            <i><a href=\"https://matomo.org/\" rel=\"noreferrer\"  target=\"_blank\">{{ linkTitle }}</a></i>
                        </p>
                    {% endif %}

                {% endblock %}
                {% endembed %}
            </div>
            <div class=\"contentForm resetForm\" style=\"display:none;\">
                {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
                {% block content %}

                    <div class=\"message_container\">
                    </div>

                    <form id=\"reset_form\" method=\"post\" ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\"/>
                                <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       size=\"20\" tabindex=\"30\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input class=\"submit btn\" id='reset_form_submit' type=\"submit\"
                                       value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                <span class=\"loadingPiwik\" style=\"display:none;\">
                                    <img alt=\"Loading\" src=\"plugins/Morpheus/images/loading-blue.gif\"/>
                                </span>
                            </div>
                        </div>

                        <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                        <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                    </form>
                    <p id=\"nav\">
                        <a id=\"reset_form_nav\" href=\"#\"
                           title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                        <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                           title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                    </p>
                {% endblock %}
                {% endembed %}
            </div>
        {% endif %}

    </section>

{% endblock %}
", "@Login/login.twig", "/var/www/html/plugins/Login/templates/login.twig");
    }
}


/* @Login/login.twig */
class __TwigTemplate_1d2e1574e9d3f539b0abd9f02e3a4aed1e5ee8e9b922afd8b9a68fb774d7d868_1195809440 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 125
        $this->parent = $this->loadTemplate("contentBlock.twig", "@Login/login.twig", 125);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "contentBlock.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 126
    public function block_content($context, array $blocks = array())
    {
        // line 127
        echo "
                    <div class=\"message_container\">
                    </div>

                    <form id=\"reset_form\" method=\"post\" ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"";
        // line 134
        echo \Piwik\piwik_escape_filter($this->env, ($context["nonce"] ?? $this->getContext($context, "nonce")), "html", null, true);
        echo "\"/>
                                <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\"/>
                                <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> ";
        // line 138
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LoginOrEmail")), "html", null, true);
        echo "</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> ";
        // line 146
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_NewPassword")), "html", null, true);
        echo "</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       size=\"20\" tabindex=\"30\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> ";
        // line 154
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_NewPasswordRepeat")), "html", null, true);
        echo "</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input class=\"submit btn\" id='reset_form_submit' type=\"submit\"
                                       value=\"";
        // line 161
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ChangePassword")), "html", null, true);
        echo "\" tabindex=\"100\"/>

                                <span class=\"loadingPiwik\" style=\"display:none;\">
                                    <img alt=\"Loading\" src=\"plugins/Morpheus/images/loading-blue.gif\"/>
                                </span>
                            </div>
                        </div>

                        <input type=\"hidden\" name=\"module\" value=\"";
        // line 169
        echo \Piwik\piwik_escape_filter($this->env, ($context["loginModule"] ?? $this->getContext($context, "loginModule")), "html", null, true);
        echo "\"/>
                        <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                    </form>
                    <p id=\"nav\">
                        <a id=\"reset_form_nav\" href=\"#\"
                           title=\"";
        // line 174
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Mobile_NavigationBack")), "html", null, true);
        echo "\">";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Cancel")), "html", null, true);
        echo "</a>
                        <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                           title=\"";
        // line 176
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LogIn")), "html", null, true);
        echo "\">";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_LogIn")), "html", null, true);
        echo "</a>
                    </p>
                ";
    }

    public function getTemplateName()
    {
        return "@Login/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  857 => 176,  850 => 174,  842 => 169,  831 => 161,  821 => 154,  810 => 146,  799 => 138,  792 => 134,  783 => 127,  780 => 126,  763 => 125,  536 => 120,  530 => 117,  527 => 116,  525 => 115,  519 => 112,  513 => 111,  508 => 109,  498 => 102,  494 => 101,  488 => 100,  478 => 93,  471 => 89,  462 => 83,  453 => 77,  449 => 75,  443 => 73,  441 => 72,  438 => 71,  430 => 68,  425 => 65,  423 => 64,  418 => 62,  413 => 59,  410 => 58,  393 => 57,  164 => 182,  160 => 180,  158 => 125,  154 => 123,  152 => 57,  149 => 56,  146 => 55,  143 => 54,  140 => 53,  130 => 44,  126 => 42,  124 => 41,  121 => 40,  113 => 38,  101 => 36,  98 => 35,  92 => 33,  90 => 32,  81 => 25,  79 => 24,  74 => 22,  70 => 21,  67 => 20,  64 => 19,  58 => 15,  49 => 8,  46 => 7,  41 => 4,  38 => 3,  34 => 1,  32 => 17,  28 => 13,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Morpheus/layout.twig' %}

{% block meta %}
    <meta name=\"robots\" content=\"index,follow\">
{% endblock %}

{% block head %}
    {{ parent() }}

    <script type=\"text/javascript\" src=\"libs/bower_components/jquery-placeholder/jquery.placeholder.js\"></script>
{% endblock %}

{% set title %}{{ 'Login_LogIn'|translate }}{% endset %}

{% block pageDescription %}{{ 'General_OpenSourceWebAnalytics'|translate }}{% endblock %}

{% set bodyId = 'loginPage' %}

{% block body %}

    {{ postEvent(\"Template.beforeTopBar\", \"login\") }}
    {{ postEvent(\"Template.beforeContent\", \"login\") }}

    {% include \"_iframeBuster.twig\" %}

    <div id=\"notificationContainer\">
    </div>
    <nav class=\"blue-grey darken-3\">
        <div class=\"nav-wrapper\">
            <span id=\"logo\" class=\"brand-logo center\">

                {% if isCustomLogo == false %}
                    <a href=\"https://matomo.org\" title=\"{{ linkTitle }}\">
                {% endif %}
                {% if hasSVGLogo %}
                    <img src='{{ logoSVG }}' class=\"{% if not isCustomLogo %}default-piwik-logo{% endif %}\" title=\"{{ linkTitle }}\" alt=\"Matomo\"/>
                {% else %}
                    <img src='{{ logoLarge }}' title=\"{{ linkTitle }}\" alt=\"Matomo\" />
                {% endif %}

                {% if isCustomLogo == false %}
                    </a>
                {% endif %}

            </span>
        </div>
    </nav>

    <section class=\"loginSection row\">
        <div class=\"col s12 m6 push-m3 l4 push-l4\">

        {# untrusted host warning #}
        {% if (isValidHost is defined and invalidHostMessage is defined and isValidHost == false) %}
            {% include '@CoreHome/_warningInvalidHost.twig' %}
        {% else %}
            <div class=\"contentForm loginForm\">
                {% embed 'contentBlock.twig' with {'title': 'Login_LogIn'|translate} %}
                {% block content %}

                    <div class=\"message_container\">

                        {{ include('@Login/_formErrors.twig', {formErrors: form_data.errors } )  }}

                        {% if AccessErrorString %}
                            <div piwik-notification
                                 noclear=\"true\"
                                 context=\"error\">
                                <strong>{{ 'General_Error'|translate }}</strong>: {{ AccessErrorString|raw }}<br/>
                            </div>
                        {% endif %}

                        {% if infoMessage %}
                            <p class=\"message\">{{ infoMessage|raw }}</p>
                        {% endif %}
                    </div>

                    <form {{ form_data.attributes|raw }} ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"text\" name=\"form_login\" placeholder=\"\" id=\"login_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\" autofocus=\"autofocus\"/>
                                <label for=\"login_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"login_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"login_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" />
                                <label for=\"login_form_password\"><i class=\"icon-locked icon\"></i> {{ 'General_Password'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input name=\"form_rememberme\" type=\"checkbox\" id=\"login_form_rememberme\" value=\"1\" tabindex=\"90\"
                                       {% if form_data.form_rememberme.value %}checked=\"checked\" {% endif %}/>
                                <label for=\"login_form_rememberme\">{{ 'Login_RememberMe'|translate }}</label>
                                <input class=\"submit btn\" id='login_form_submit' type=\"submit\" value=\"{{ 'Login_LogIn'|translate }}\"
                                       tabindex=\"100\"/>
                            </div>
                        </div>

                    </form>
                    <p id=\"nav\">
                        {{ postEvent(\"Template.loginNav\", \"top\") }}
                        <a id=\"login_form_nav\" href=\"#\"
                           title=\"{{ 'Login_LostYourPassword'|translate }}\">{{ 'Login_LostYourPassword'|translate }}</a>
                        {{ postEvent(\"Template.loginNav\", \"bottom\") }}
                    </p>

                    {% if isCustomLogo %}
                        <p id=\"piwik\">
                            <i><a href=\"https://matomo.org/\" rel=\"noreferrer\"  target=\"_blank\">{{ linkTitle }}</a></i>
                        </p>
                    {% endif %}

                {% endblock %}
                {% endembed %}
            </div>
            <div class=\"contentForm resetForm\" style=\"display:none;\">
                {% embed 'contentBlock.twig' with {'title': 'Login_ChangeYourPassword'|translate} %}
                {% block content %}

                    <div class=\"message_container\">
                    </div>

                    <form id=\"reset_form\" method=\"post\" ng-non-bindable>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"hidden\" name=\"form_nonce\" id=\"reset_form_nonce\" value=\"{{ nonce }}\"/>
                                <input type=\"text\" placeholder=\"\" name=\"form_login\" id=\"reset_form_login\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"10\"/>
                                <label for=\"reset_form_login\"><i class=\"icon-user icon\"></i> {{ 'Login_LoginOrEmail'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password\" id=\"reset_form_password\" class=\"input\" value=\"\" size=\"20\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       tabindex=\"20\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPassword'|translate }}</label>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col s12 input-field\">
                                <input type=\"password\" placeholder=\"\" name=\"form_password_bis\" id=\"reset_form_password_bis\" class=\"input\" value=\"\"
                                       autocorrect=\"off\" autocapitalize=\"none\"
                                       size=\"20\" tabindex=\"30\" autocomplete=\"off\"/>
                                <label for=\"reset_form_password_bis\"><i class=\"icon-locked icon\"></i> {{ 'Login_NewPasswordRepeat'|translate }}</label>
                            </div>
                        </div>

                        <div class=\"row actions\">
                            <div class=\"col s12\">
                                <input class=\"submit btn\" id='reset_form_submit' type=\"submit\"
                                       value=\"{{ 'General_ChangePassword'|translate }}\" tabindex=\"100\"/>

                                <span class=\"loadingPiwik\" style=\"display:none;\">
                                    <img alt=\"Loading\" src=\"plugins/Morpheus/images/loading-blue.gif\"/>
                                </span>
                            </div>
                        </div>

                        <input type=\"hidden\" name=\"module\" value=\"{{ loginModule }}\"/>
                        <input type=\"hidden\" name=\"action\" value=\"resetPassword\"/>
                    </form>
                    <p id=\"nav\">
                        <a id=\"reset_form_nav\" href=\"#\"
                           title=\"{{ 'Mobile_NavigationBack'|translate }}\">{{ 'General_Cancel'|translate }}</a>
                        <a id=\"alternate_reset_nav\" href=\"#\" style=\"display:none;\"
                           title=\"{{'Login_LogIn'|translate}}\">{{ 'Login_LogIn'|translate }}</a>
                    </p>
                {% endblock %}
                {% endembed %}
            </div>
        {% endif %}

    </section>

{% endblock %}
", "@Login/login.twig", "/var/www/html/plugins/Login/templates/login.twig");
    }
}
