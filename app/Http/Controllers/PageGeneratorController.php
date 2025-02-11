<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageSet;
use Illuminate\Support\Str;

class PageGeneratorController extends Controller
{
    /**
     * Exibe o formulário do Page Generator.
     */
    public function index()
    {
        return view('pagegenerator.index');
    }

    public function list()
    {
        $pages = \App\Models\Page::all();
        return view('pagegenerator.list', compact('pages'));
    }



    /**
     * Processa o formulário e gera as páginas a partir do CSV, criando um registro pai (PageSet).
     */
    public function generate(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'title_template'    => 'required|string',
            'content_template'  => 'required|string',
            'csv_file'          => 'required|file|mimes:csv,txt',
            'published_at'      => 'nullable|date',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string'
        ]);

        // Cria o registro pai (PageSet) com os templates e campos comuns
        $pageSet = PageSet::create([
            'title_template'   => $request->title_template,
            'content_template' => $request->content_template,
            'published_at'     => $request->published_at,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
        ]);

        // Lê e converte o CSV para array
        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->getRealPath()));

        if (count($csvData) < 2) {
            return back()->with('error', 'O arquivo CSV deve conter um cabeçalho e pelo menos uma linha de dados.');
        }

        $headers = $csvData[0];
        $pagesCreated = 0;
        $pagesSkipped = 0;
        $errors = [];

        // Itera sobre as linhas de dados (pulando o cabeçalho)
        for ($i = 1; $i < count($csvData); $i++) {
            $row = $csvData[$i];

            if (count($row) != count($headers)) {
                $errors[] = "A linha " . ($i + 1) . " não possui a mesma quantidade de colunas do cabeçalho.";
                continue;
            }

            // Cria um array associativo com os dados da linha
            $data = array_combine($headers, $row);

            // Substitui os placeholders dos templates para título, conteúdo e campos SEO
            $pageTitle = $request->title_template;
            $pageContent = $request->content_template;
            $metaDescriptionFinal = $request->meta_description;
            $metaKeywordsFinal = $request->meta_keywords;

            foreach ($data as $key => $value) {
                $pageTitle = str_replace('{' . $key . '}', $value, $pageTitle);
                $pageContent = str_replace('{' . $key . '}', $value, $pageContent);
                $metaDescriptionFinal = str_replace('{' . $key . '}', $value, $metaDescriptionFinal);
                $metaKeywordsFinal = str_replace('{' . $key . '}', $value, $metaKeywordsFinal);
            }

            // Gera o slug a partir do título
            $slug = Str::slug($pageTitle);

            // Verifica se já existe uma página com o mesmo slug
            if (Page::where('slug', $slug)->exists()) {
                $pagesSkipped++;
                continue;
            }

            // Cria a página associada ao PageSet criado
            Page::create([
                'title'            => $pageTitle,
                'slug'             => $slug,
                'content'          => $pageContent,
                'published_at'     => $request->published_at,
                'meta_description' => $metaDescriptionFinal,
                'meta_keywords'    => $metaKeywordsFinal,
                'page_set_id'      => $pageSet->id,
            ]);

            $pagesCreated++;
        }

        // Monta a mensagem de retorno
        $message = "$pagesCreated página(s) gerada(s) com sucesso.";
        if ($pagesSkipped > 0) {
            $message .= " $pagesSkipped página(s) já existiam e foram puladas.";
        }
        if (!empty($errors)) {
            $message .= " Alguns erros ocorreram: " . implode(" ", $errors);
        }

        return redirect()->route('page.generator.list')->with('success', $message);
    }



    public function edit($id)
    {
        $page = \App\Models\Page::findOrFail($id);
        return view('pagegenerator.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = \App\Models\Page::findOrFail($id);

        $request->validate([
            'title'            => 'required|string',
            'content'          => 'required|string',
            'published_at'     => 'nullable|date',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string'
        ]);

        // Gera o slug a partir do título e verifica duplicidade
        $slug = \Illuminate\Support\Str::slug($request->title);
        if (\App\Models\Page::where('slug', $slug)->where('id', '<>', $id)->exists()) {
            return redirect()->back()
                ->withErrors(['title' => 'Já existe uma página com esse título. Por favor, escolha outro título.'])
                ->withInput();
        }

        $page->update([
            'title'            => $request->title,
            'slug'             => $slug,
            'content'          => $request->content,
            'published_at'     => $request->published_at,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
        ]);

        return redirect()->route('page.generator.list')->with('success', 'Página atualizada com sucesso.');
    }



    public function destroy($id)
    {
        $page = \App\Models\Page::findOrFail($id);
        $page->delete();

        return redirect()->route('page.generator.list')->with('success', 'Página excluída com sucesso.');
    }


    public function show($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        return view('pagegenerator.show', compact('page'));
    }


    
    public function listPageSets()
    {
        // Carrega os PageSets com as páginas relacionadas (eager loading)
        $pageSets = \App\Models\PageSet::with('pages')->orderBy('created_at', 'desc')->get();
        return view('pagegenerator.pagelist', compact('pageSets'));
    }

    /**
     * Exibe o formulário de edição de um PageSet.
     */
    public function editPageSet($id)
    {
        $pageSet = PageSet::findOrFail($id);
        return view('pagegenerator.pageset-edit', compact('pageSet'));
    }

    /**
     * Atualiza o PageSet com os dados enviados.
     */
    public function updatePageSet(Request $request, $id)
    {
        // Carrega o PageSet com suas páginas associadas
    $pageSet = \App\Models\PageSet::with('pages')->findOrFail($id);

    $request->validate([
        'title_template'   => 'required|string',
        'content_template' => 'required|string',
        'published_at'     => 'nullable|date',
        'meta_description' => 'nullable|string',
        'meta_keywords'    => 'nullable|string',
        'csv_file'         => 'nullable|file|mimes:csv,txt',
    ]);

    // Atualiza os campos do PageSet (exceto csv_file por enquanto)
    $pageSet->update($request->only([
        'title_template',
        'content_template',
        'published_at',
        'meta_description',
        'meta_keywords'
    ]));

    if ($request->hasFile('csv_file')) {
        // Se um novo CSV for enviado, armazena-o e atualiza o campo no PageSet
        $csv = $request->file('csv_file');
        $csvPath = $csv->store('csv_uploads');
        $pageSet->update(['csv_file' => $csvPath]);

        // Para simplificar, apaga as páginas existentes e gera novas a partir do novo CSV
        $pageSet->pages()->delete();

        $csvData = array_map('str_getcsv', file(storage_path('app/' . $csvPath)));
        if (count($csvData) < 2) {
            return redirect()->back()->with('error', 'O arquivo CSV deve conter um cabeçalho e pelo menos uma linha de dados.');
        }
        $headers = $csvData[0];

        // Itera sobre cada linha do CSV (após o cabeçalho)
        for ($i = 1; $i < count($csvData); $i++) {
            $row = $csvData[$i];
            if (count($row) != count($headers)) {
                // Se a linha estiver inconsistente, pule-a
                continue;
            }
            $data = array_combine($headers, $row);

            // Salva os dados originais na página (para reprocessamento futuro)
            $substitutionData = json_encode($data);

            // Aplica os templates com substituição
            $newTitle = $pageSet->title_template;
            $newContent = $pageSet->content_template;
            $newMetaDescription = $pageSet->meta_description;
            $newMetaKeywords = $pageSet->meta_keywords;
            foreach ($data as $key => $value) {
                $newTitle = str_replace('{' . $key . '}', $value, $newTitle);
                $newContent = str_replace('{' . $key . '}', $value, $newContent);
                $newMetaDescription = str_replace('{' . $key . '}', $value, $newMetaDescription);
                $newMetaKeywords = str_replace('{' . $key . '}', $value, $newMetaKeywords);
            }

            // Gera um slug único
            $baseSlug = \Illuminate\Support\Str::slug($newTitle);
            $newSlug = $baseSlug;
            $counter = 1;
            while (\App\Models\Page::where('slug', $newSlug)->exists()) {
                $newSlug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Cria a página nova associada ao PageSet
            \App\Models\Page::create([
                'title'            => $newTitle,
                'slug'             => $newSlug,
                'content'          => $newContent,
                'published_at'     => $pageSet->published_at,
                'meta_description' => $newMetaDescription,
                'meta_keywords'    => $newMetaKeywords,
                'substitution_data'=> $substitutionData,
                'page_set_id'      => $pageSet->id,
            ]);
        }
    } else {
        // Se não houver novo CSV, reprocessa cada página usando os dados de substituição já salvos
        foreach ($pageSet->pages as $page) {
            $data = json_decode($page->substitution_data, true);
            if (!is_array($data)) {
                continue;
            }

            $newTitle = $pageSet->title_template;
            $newContent = $pageSet->content_template;
            $newMetaDescription = $pageSet->meta_description;
            $newMetaKeywords = $pageSet->meta_keywords;
            foreach ($data as $key => $value) {
                $newTitle = str_replace('{' . $key . '}', $value, $newTitle);
                $newContent = str_replace('{' . $key . '}', $value, $newContent);
                $newMetaDescription = str_replace('{' . $key . '}', $value, $newMetaDescription);
                $newMetaKeywords = str_replace('{' . $key . '}', $value, $newMetaKeywords);
            }

            // Gera slug único
            $baseSlug = \Illuminate\Support\Str::slug($newTitle);
            $newSlug = $baseSlug;
            $counter = 1;
            while (\App\Models\Page::where('slug', $newSlug)
                    ->where('id', '<>', $page->id)
                    ->exists()) {
                $newSlug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $page->update([
                'title'            => $newTitle,
                'slug'             => $newSlug,
                'content'          => $newContent,
                'published_at'     => $pageSet->published_at,
                'meta_description' => $newMetaDescription,
                'meta_keywords'    => $newMetaKeywords,
            ]);
        }
    }

        return redirect()->route('page_sets.list')
            ->with('success', 'Conjunto de páginas atualizado com sucesso e páginas dependentes reprocessadas.');
    }



    /**
     * Exclui o PageSet e, em cascata, as páginas associadas.
     */
    public function destroyPageSet($id)
    {
        $pageSet = PageSet::findOrFail($id);
        $pageSet->delete(); // Como a migration definiu onDelete('cascade'), as páginas associadas serão removidas.
        return redirect()->route('page_sets.list')->with('success', 'Conjunto de páginas excluído com sucesso.');
    }

}
