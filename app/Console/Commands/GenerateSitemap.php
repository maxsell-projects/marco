<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Property;

class GenerateSitemap extends Command
{
    /**
     * O nome e assinatura do comando no terminal.
     */
    protected $signature = 'sitemap:generate';

    /**
     * A descrição do comando.
     */
    protected $description = 'Gera o sitemap.xml para indexação SEO';

    /**
     * Executa o comando.
     */
    public function handle()
    {
        $this->info('A iniciar geração do Sitemap...');

        $sitemap = Sitemap::create();

        // --- 1. PÁGINAS ESTÁTICAS ---
        // Home (Prioridade Máxima)
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Institucionais
        $sitemap->add(Url::create('/portfolio')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create('/contact')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Ferramentas (Landing Pages importantes para captar leads)
        $sitemap->add(Url::create('/tools/credit-simulator')->setPriority(0.7));
        $sitemap->add(Url::create('/tools/imt-simulator')->setPriority(0.7));
        $sitemap->add(Url::create('/tools/capital-gains')->setPriority(0.7));

        // --- 2. IMÓVEIS DINÂMICOS ---
        $this->info('A adicionar imóveis...');
        
        Property::where('is_visible', true)->chunk(100, function ($properties) use ($sitemap) {
            foreach ($properties as $property) {
                $sitemap->add(
                    Url::create(route('properties.show', $property->slug))
                        ->setLastModificationDate($property->updated_at)
                        ->setPriority(0.9) // Imóveis têm alta prioridade
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            }
        });

        // --- 3. SALVAR ARQUIVO ---
        // Salva na pasta public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap gerado com sucesso em public/sitemap.xml!');
    }
}