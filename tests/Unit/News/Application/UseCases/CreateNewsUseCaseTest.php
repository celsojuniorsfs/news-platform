<?php

declare(strict_types=1);

namespace Tests\Unit\News\Application\UseCases;

use PHPUnit\Framework\TestCase;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Application\UseCases\CreateNewsUseCase;
use Src\News\Domain\Contracts\NewsRepository;
use Src\News\Infrastructure\Models\News;

final class CreateNewsUseCaseTest extends TestCase
{
    public function test_it_creates_a_news_successfully(): void
    {
        // Arrange
        $input = new CreateNewsInput(
            title: 'Test News',
            content: 'This is a test news content',
            categoryId: 1,
        );

        $expectedNews = new News();
        $expectedNews->id = 1;
        $expectedNews->title = $input->title;
        $expectedNews->content = $input->content;
        $expectedNews->category_id = $input->categoryId;

        $repositoryMock = $this->createMock(NewsRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($input)
            ->willReturn($expectedNews);

        $useCase = new CreateNewsUseCase($repositoryMock);

        // Act
        $result = $useCase->execute($input);

        // Assert
        $this->assertSame($expectedNews, $result);
        $this->assertEquals('Test News', $result->title);
        $this->assertEquals('This is a test news content', $result->content);
        $this->assertEquals(1, $result->category_id);
    }
}

