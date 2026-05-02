<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure.html.twig */
class __TwigTemplate_82c302e2404b49ce82b97eef6ea81d14 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<article";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["ilf-structured-node", "ilf-structured-node--resource"], "method", false, false, true, 1), "html", null, true);
        yield ">
  <header class=\"fujitsu-page-hero\">
    <div class=\"container\">
      <p class=\"fujitsu-eyebrow\">Fujitsu Resource</p>
      <h1>";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
        yield "</h1>
    </div>
  </header>

  <div class=\"fujitsu-page-body\">
    <div class=\"container\">
      <div class=\"ilf-detail-card ilf-resource-detail\">
        <div class=\"ilf-detail-card__main\">
          ";
        // line 13
        if ((($tmp = ($context["resource_category"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 14
            yield "            <p class=\"ilf-kicker\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_category"] ?? null), "html", null, true);
            yield "</p>
          ";
        }
        // line 16
        yield "          ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "body", [], "any", false, false, true, 16), "html", null, true);
        yield "
        </div>
        <aside class=\"ilf-detail-card__aside\" aria-label=\"Resource actions\">
          <h2>Use this before the estimate</h2>
          <p>Review the material, compare the Fujitsu advantage, then ask your contractor which Fujitsu option best fits your space.</p>
          ";
        // line 21
        if ((($tmp = ($context["resource_file_size"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 22
            yield "            <div class=\"ilf-resource-meta ilf-resource-meta--large\">
              <span class=\"ilf-resource-icon\" aria-hidden=\"true\">PDF</span>
              <span>";
            // line 24
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_file_size"] ?? null), "html", null, true);
            yield "</span>
            </div>
          ";
        }
        // line 27
        yield "          ";
        if ((($tmp = ($context["resource_file_url"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 28
            yield "            <a class=\"btn-main\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_file_url"] ?? null), "html", null, true);
            yield "\">Download PDF</a>
          ";
        } elseif ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,         // line 29
($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 29), "uri", [], "any", false, false, true, 29)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 30
            yield "            ";
            $context["resource_href"] = (((is_string($_v0 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 30), "uri", [], "any", false, false, true, 30)) && is_string($_v1 = "internal:") && str_starts_with($_v0, $_v1))) ? (Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 30), "uri", [], "any", false, false, true, 30), ["internal:" => ""])) : (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 30), "uri", [], "any", false, false, true, 30)));
            // line 31
            yield "            <a class=\"btn-main\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_href"] ?? null), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 31), "title", [], "any", false, false, true, 31)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 31), "title", [], "any", false, false, true, 31), "html", null, true)) : ("Open resource"));
            yield "</a>
          ";
        }
        // line 33
        yield "          <a class=\"btn-main btn-outline\" href=\"/compare\">Compare Fujitsu vs other brands</a>
          <a class=\"btn-main btn-outline\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer</a>
        </aside>
      </div>
    </div>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "label", "resource_category", "content", "resource_file_size", "resource_file_url", "node"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  113 => 33,  105 => 31,  102 => 30,  100 => 29,  95 => 28,  92 => 27,  86 => 24,  82 => 22,  80 => 21,  71 => 16,  65 => 14,  63 => 13,  52 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 13, "set" => 30];
        static $filters = ["escape" => 1, "replace" => 30];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set'],
                ['escape', 'replace'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
