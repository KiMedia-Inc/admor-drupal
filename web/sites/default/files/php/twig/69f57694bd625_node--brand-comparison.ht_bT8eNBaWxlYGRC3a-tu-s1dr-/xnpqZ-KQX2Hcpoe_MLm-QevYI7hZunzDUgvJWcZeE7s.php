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

/* themes/custom/ilovemyfujitsu/templates/content/node--brand-comparison.html.twig */
class __TwigTemplate_0c2a88805338f595d3c910b74a8fe934 extends Template
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
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["ilf-structured-node", "ilf-brand-comparison"], "method", false, false, true, 1), "html", null, true);
        yield ">
  <header class=\"fujitsu-page-hero ilf-brand-comparison__hero\">
    <div class=\"container\">
      <p class=\"fujitsu-eyebrow\">Fujitsu brand comparison</p>
      <h1>";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
        yield "</h1>
      ";
        // line 6
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_comparison_summary", [], "any", false, false, true, 6), "value", [], "any", false, false, true, 6)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "        <p>";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_comparison_summary", [], "any", false, false, true, 7), "value", [], "any", false, false, true, 7), "html", null, true);
            yield "</p>
      ";
        }
        // line 9
        yield "      <div class=\"fujitsu-actions\">
        <a class=\"btn-main\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer</a>
        <a class=\"btn-main btn-outline\" href=\"/products\">Explore Fujitsu Products</a>
      </div>
    </div>
  </header>

  <div class=\"fujitsu-page-body\">
    <div class=\"container\">
      <section class=\"ilf-brand-comparison__chooser\" aria-labelledby=\"comparison-brand-chooser\">
        <div>
          <p class=\"fujitsu-eyebrow\">Compare before you choose</p>
          <h2 id=\"comparison-brand-chooser\">Which mini-split brand are you considering?</h2>
          <p>Select the brand your contractor quoted or the brand you are researching, then see why Fujitsu is often the stronger choice for Hawaii homes, coastal conditions, warranty confidence, and local support.</p>
        </div>
        <nav class=\"ilf-brand-comparison__nav\" aria-label=\"Fujitsu brand comparisons\">
          <a href=\"/fujitsu-vs-mitsubishi\">Mitsubishi</a>
          <a href=\"/fujitsu-vs-daikin\">Daikin</a>
          <a href=\"/fujitsu-vs-lg\">LG</a>
          <a href=\"/fujitsu-vs-gree\">Gree</a>
          <a href=\"/fujitsu-vs-panasonic\">Panasonic</a>
        </nav>
      </section>
      <div class=\"ilf-brand-comparison__content\">
        ";
        // line 33
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "body", [], "any", false, false, true, 33), "html", null, true);
        yield "
      </div>
      ";
        // line 35
        if ((($tmp = ($context["ilf_testimonials"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 36
            yield "        <section class=\"ilf-testimonials ilf-testimonials--embedded\">
          <div class=\"fujitsu-section-heading\">
            <p class=\"fujitsu-eyebrow\">Customer proof</p>
            <h2>What Hawaii buyers are saying about Fujitsu.</h2>
          </div>
          <div class=\"ilf-testimonials__grid\">
            ";
            // line 42
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["ilf_testimonials"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 43
                yield "              <article>
                <p>“";
                // line 44
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 44)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quote", [], "any", false, false, true, 44), "html", null, true)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "summary", [], "any", false, false, true, 44), "html", null, true)));
                yield "”</p>
                <strong>";
                // line 45
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 45), "html", null, true);
                yield "</strong>
                ";
                // line 46
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 46) || CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 46))) {
                    yield "<span>";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 46), "html", null, true);
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "island", [], "any", false, false, true, 46) && CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 46))) {
                        yield " / ";
                    }
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "system", [], "any", false, false, true, 46), "html", null, true);
                    yield "</span>";
                }
                // line 47
                yield "              </article>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 49
            yield "          </div>
        </section>
      ";
        }
        // line 52
        yield "      <section class=\"ilf-listing-cta ilf-listing-cta--comparison\">
        <div>
          <strong>Ready to turn the comparison into a quote?</strong>
          <span>Bring this page to your AC contractor and ask them to quote Fujitsu specifically for your home, business, island, and long-term service needs.</span>
        </div>
        <p>
          <a class=\"btn-main\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer</a>
          <a class=\"btn-main btn-outline\" href=\"/products\">Explore Fujitsu Products</a>
        </p>
      </section>
    </div>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "label", "node", "content", "ilf_testimonials"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/content/node--brand-comparison.html.twig";
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
        return array (  142 => 52,  137 => 49,  130 => 47,  120 => 46,  116 => 45,  112 => 44,  109 => 43,  105 => 42,  97 => 36,  95 => 35,  90 => 33,  64 => 9,  58 => 7,  56 => 6,  52 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/content/node--brand-comparison.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/content/node--brand-comparison.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 6, "for" => 42];
        static $filters = ["escape" => 1];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape'],
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
