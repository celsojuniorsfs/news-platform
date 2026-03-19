<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Src\Category\Infrastructure\Models\Category;
use Src\News\Infrastructure\Models\News;

final class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()
            ->pluck('id', 'name');

        $fixedNews = [
            [
                'title' => 'Laravel 12 melhora produtividade em projetos modulares',
                'content' => 'Equipes de desenvolvimento relatam ganhos de produtividade ao adotar Laravel 12 em arquiteturas modulares, com melhor organização de código, padronização e facilidade de manutenção em sistemas de médio porte.',
                'category' => 'Tecnologia',
            ],
            [
                'title' => 'Mercado de tecnologia amplia vagas para backend PHP',
                'content' => 'Empresas seguem abrindo oportunidades para desenvolvedores backend com experiência em PHP, Laravel, integração com filas, bancos relacionais e arquitetura limpa.',
                'category' => 'Negócios',
            ],
            [
                'title' => 'Times priorizam testes automatizados para reduzir falhas em produção',
                'content' => 'A adoção de testes automatizados vem crescendo em times de produto que precisam acelerar entregas sem comprometer a estabilidade do sistema em produção.',
                'category' => 'Tecnologia',
            ],
            [
                'title' => 'Economia digital impulsiona investimento em plataformas de conteúdo',
                'content' => 'O crescimento da economia digital aumenta o interesse em plataformas de publicação, gestão de conteúdo e portais de notícias especializados.',
                'category' => 'Economia',
            ],
            [
                'title' => 'Setor de games registra alta no engajamento de comunidades online',
                'content' => 'Comunidades online de games seguem em expansão, impulsionando consumo de notícias, análises, lançamentos e conteúdos multimídia ligados ao setor.',
                'category' => 'Games',
            ],
            [
                'title' => 'Clubes investem em análise de desempenho e dados esportivos',
                'content' => 'A profissionalização do esporte amplia o uso de dados, inteligência analítica e sistemas de acompanhamento de desempenho em clubes e organizações.',
                'category' => 'Esportes',
            ],
            [
                'title' => 'Pesquisa científica avança com apoio de inteligência artificial',
                'content' => 'Instituições de pesquisa relatam ganhos de velocidade em análises preliminares, classificação de conteúdo e apoio à descoberta de padrões com uso de IA.',
                'category' => 'Ciência',
            ],
            [
                'title' => 'Educação digital cresce com uso de plataformas online',
                'content' => 'Ambientes virtuais de aprendizagem continuam crescendo e reforçam a demanda por sistemas confiáveis, escaláveis e simples de operar.',
                'category' => 'Educação',
            ],
            [
                'title' => 'Saúde preventiva ganha espaço em programas corporativos',
                'content' => 'Empresas ampliam ações voltadas à saúde preventiva, bem-estar e acompanhamento de indicadores para promover mais qualidade de vida.',
                'category' => 'Saúde',
            ],
            [
                'title' => 'Produção de entretenimento aposta em distribuição multiplataforma',
                'content' => 'Produtoras e veículos de mídia ampliam a distribuição de conteúdo em diferentes plataformas para alcançar novos públicos e formatos de consumo.',
                'category' => 'Entretenimento',
            ],
        ];

        foreach ($fixedNews as $item) {
            $categoryId = $categories[$item['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            News::query()->updateOrCreate(
                ['title' => $item['title']],
                [
                    'content' => $item['content'],
                    'excerpt' => Str::limit($item['content'], 180),
                    'category_id' => $categoryId,
                ]
            );
        }

        $allCategoryIds = Category::query()->pluck('id')->all();

        News::factory()
            ->count(40)
            ->state(fn (): array => [
                'category_id' => fake()->randomElement($allCategoryIds),
            ])
            ->create();
    }
}
