<?php

declare(strict_types=1);

namespace Drupal\Tests\drupal_cms_news\Functional;

use Drupal\FunctionalTests\Core\Recipe\RecipeTestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * @group drupal_cms_news
 */
class ComponentValidationTest extends BrowserTestBase {

  use RecipeTestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $dir = realpath(__DIR__ . '/../../..');
    // The recipe should apply cleanly.
    $this->applyRecipe($dir);
    // Apply it again to prove that it is idempotent.
    $this->applyRecipe($dir);
  }

  public function testPathAliasPatternPrecedence(): void {
    $dir = realpath(__DIR__ . '/../../../../drupal_cms_seo_basic');
    $this->applyRecipe($dir);

    // Confirm that news items have the expected path aliases.
    $node = $this->drupalCreateNode([
      'type' => 'news',
      'title' => 'Test News',
    ]);
    $now = date('Y-m', $node->getCreatedTime());
    $this->assertStringEndsWith("/news/$now/test-news", $node->toUrl()->toString());
  }

}
