<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
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
     * Processa o formulário e gera as páginas a partir do CSV.
     */
    public function generate(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'title_template'   => 'required|string',
            'content_template' => 'required|string',
            'csv_file'         => 'required|file|mimes:csv,txt',
            'published_at'     => 'nullable|date',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string'
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

        // Recupera os templates dos novos campos
        $publishedAt = $request->published_at;
        $metaDescriptionTemplate = $request->meta_description ?? '';
        $metaKeywordsTemplate = $request->meta_keywords ?? '';

        // Itera sobre as linhas de dados (pulando o cabeçalho)
        for ($i = 1; $i < count($csvData); $i++) {
            $row = $csvData[$i];

            if (count($row) != count($headers)) {
                $errors[] = "A linha " . ($i + 1) . " não possui a mesma quantidade de colunas do cabeçalho.";
                continue;
            }

            // Cria um array associativo com os dados da linha
            $data = array_combine($headers, $row);

            // Substituição de placeholders para título, conteúdo e campos SEO
            $pageTitle = $request->title_template;
            $pageContent = $request->content_template;
            $metaDescriptionFinal = $metaDescriptionTemplate;
            $metaKeywordsFinal = $metaKeywordsTemplate;

            foreach ($data as $key => $value) {
                $pageTitle = str_replace('{' . $key . '}', $value, $pageTitle);
                $pageContent = str_replace('{' . $key . '}', $value, $pageContent);
                $metaDescriptionFinal = str_replace('{' . $key . '}', $value, $metaDescriptionFinal);
                $metaKeywordsFinal = str_replace('{' . $key . '}', $value, $metaKeywordsFinal);
            }

            // Gera o slug a partir do título
            $slug = \Illuminate\Support\Str::slug($pageTitle);

            // Verifica se já existe uma página com o mesmo slug
            if (\App\Models\Page::where('slug', $slug)->exists()) {
                $pagesSkipped++;
                continue;
            }

            // Cria o registro da página no banco de dados
            \App\Models\Page::create([
                'title'            => $pageTitle,
                'slug'             => $slug,
                'content'          => $pageContent,
                'published_at'     => $publishedAt,
                'meta_description' => $metaDescriptionFinal,
                'meta_keywords'    => $metaKeywordsFinal,
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

        // Redireciona para a tela de listagem das páginas com a mensagem de sucesso
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

}
