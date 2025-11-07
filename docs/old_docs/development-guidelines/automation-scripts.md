# Scripts de Automação para I18n

## 🤖 **Ferramentas para Futura Internacionalização**

Esta pasta contém scripts PHP que serão usados quando decidirmos implementar internacionalização no projeto principal.

---

## 📁 **Estrutura dos Scripts**

```
scripts/i18n/
├── TextExtractor.php           # Extrai textos do código
├── KeyMapper.php               # Mapeia textos para chaves i18n
├── CodeTransformer.php         # Aplica data-i18n no HTML
├── TranslationGenerator.php    # Gera arquivos de tradução
├── CoverageAnalyzer.php        # Analisa cobertura de tradução
└── MigrationRunner.php         # Executa migração completa
```

---

## 🔍 **TextExtractor.php**

### **Função:** Extrair todos os textos traduzíveis do código PHP/HTML

```php
<?php
/**
 * Extrai textos do código para futura internacionalização
 * 
 * Identifica:
 * - Textos em templates HTML
 * - Mensagens em arrays/constantes PHP
 * - Strings em métodos específicos
 * - Labels e placeholders
 */
class TextExtractor 
{
    private $patterns = [
        // Templates HTML
        'html_titles' => '/<h[1-6][^>]*class="([^"]*(?:title|header)[^"]*)"[^>]*>([^<]+)<\/h[1-6]>/',
        'html_buttons' => '/<button[^>]*class="([^"]*action-[^"]*)"[^>]*>([^<]+)<\/button>/',
        'html_labels' => '/<label[^>]*class="([^"]*label-[^"]*)"[^>]*>([^<]+)<\/label>/',
        
        // PHP Arrays/Constants
        'php_messages' => '/(?:const\s+MESSAGES|static\s+\$messages)\s*=\s*\[(.*?)\];/s',
        'php_strings' => '/[\'"]([^\'"\n]{3,})[\'"]/',
        
        // Específicos do projeto
        'page_titles' => '/<title>([^<]+)<\/title>/',
        'placeholder_text' => '/placeholder\s*=\s*[\'"]([^\'"\n]+)[\'"]/',
    ];
    
    public function extractFromDirectory($directory) 
    {
        $texts = [];
        $files = $this->scanDirectory($directory);
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $fileTexts = $this->extractFromContent($content, $file);
            $texts = array_merge($texts, $fileTexts);
        }
        
        return $this->deduplicateTexts($texts);
    }
    
    private function extractFromContent($content, $file) 
    {
        $texts = [];
        
        foreach ($this->patterns as $type => $pattern) {
            preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);
            
            foreach ($matches[0] as $index => $match) {
                $texts[] = [
                    'text' => trim($matches[2][$index][0] ?? $matches[1][$index][0]),
                    'type' => $type,
                    'file' => $file,
                    'line' => $this->getLineNumber($content, $match[1]),
                    'context' => $this->getContext($content, $match[1]),
                    'css_class' => $matches[1][$index][0] ?? null
                ];
            }
        }
        
        return $texts;
    }
    
    private function getLineNumber($content, $offset) 
    {
        return substr_count(substr($content, 0, $offset), "\n") + 1;
    }
    
    private function getContext($content, $offset) 
    {
        $lines = explode("\n", $content);
        $lineNum = $this->getLineNumber($content, $offset);
        
        $start = max(0, $lineNum - 3);
        $end = min(count($lines), $lineNum + 3);
        
        return array_slice($lines, $start, $end - $start);
    }
}
?>
```

---

## 🗝️ **KeyMapper.php**

### **Função:** Mapear textos extraídos para chaves de tradução semânticas

```php
<?php
/**
 * Mapeia textos para chaves i18n baseado em contexto e padrões
 */
class KeyMapper 
{
    private $mappingRules = [
        // Padrões por tipo
        'html_titles' => [
            'pattern' => '/^(.+)$/',
            'key' => 'pages.{page}.title'
        ],
        'html_buttons' => [
            'action-save' => 'buttons.save',
            'action-cancel' => 'buttons.cancel',
            'action-edit' => 'buttons.edit',
            'action-delete' => 'buttons.delete',
            'action-create' => 'buttons.create'
        ],
        'html_labels' => [
            'label-name' => 'labels.name',
            'label-email' => 'labels.email',
            'label-password' => 'labels.password'
        ]
    ];
    
    private $contextMapping = [
        '/users/' => 'users',
        '/dashboard/' => 'dashboard',
        '/reports/' => 'reports',
        '/settings/' => 'settings'
    ];
    
    public function mapTextsToKeys($extractedTexts) 
    {
        $mappings = [];
        
        foreach ($extractedTexts as $text) {
            $key = $this->generateKey($text);
            $mappings[] = [
                'original_text' => $text['text'],
                'suggested_key' => $key,
                'context' => $this->getPageContext($text['file']),
                'type' => $text['type'],
                'file' => $text['file'],
                'line' => $text['line'],
                'css_class' => $text['css_class'],
                'priority' => $this->calculatePriority($text)
            ];
        }
        
        return $this->sortByPriority($mappings);
    }
    
    private function generateKey($text) 
    {
        $type = $text['type'];
        $content = $text['text'];
        $cssClass = $text['css_class'];
        $context = $this->getPageContext($text['file']);
        
        // Mapear por classe CSS primeiro
        if ($cssClass && isset($this->mappingRules[$type][$cssClass])) {
            return $this->mappingRules[$type][$cssClass];
        }
        
        // Mapear por padrão de conteúdo
        switch ($type) {
            case 'html_titles':
                return "pages.{$context}." . $this->textToKey($content);
                
            case 'html_buttons':
                return "buttons." . $this->textToKey($content);
                
            case 'html_labels':
                return "labels." . $this->textToKey($content);
                
            case 'php_messages':
                return "messages." . $this->textToKey($content);
                
            default:
                return "common." . $this->textToKey($content);
        }
    }
    
    private function textToKey($text) 
    {
        // Converter texto para chave semântica
        $key = strtolower($text);
        $key = preg_replace('/[^a-z0-9\s]/', '', $key);
        $key = preg_replace('/\s+/', '_', $key);
        $key = trim($key, '_');
        
        return $key;
    }
    
    private function getPageContext($file) 
    {
        foreach ($this->contextMapping as $pattern => $context) {
            if (strpos($file, $pattern) !== false) {
                return $context;
            }
        }
        
        // Extrair contexto do nome do arquivo
        $filename = basename($file, '.php');
        return strtolower($filename);
    }
    
    private function calculatePriority($text) 
    {
        $priority = 0;
        
        // Maior prioridade para elementos de navegação
        if (strpos($text['css_class'], 'nav-') === 0) $priority += 10;
        
        // Maior prioridade para botões de ação
        if (strpos($text['css_class'], 'action-') === 0) $priority += 8;
        
        // Maior prioridade para títulos
        if ($text['type'] === 'html_titles') $priority += 7;
        
        // Menor prioridade para textos longos
        if (strlen($text['text']) > 50) $priority -= 3;
        
        return $priority;
    }
}
?>
```

---

## 🔄 **CodeTransformer.php**

### **Função:** Aplicar data-i18n nos templates HTML baseado no mapeamento

```php
<?php
/**
 * Transforma código HTML adicionando atributos data-i18n
 */
class CodeTransformer 
{
    public function applyI18nAttributes($file, $mappings) 
    {
        $content = file_get_contents($file);
        $originalContent = $content;
        
        foreach ($mappings as $mapping) {
            if ($mapping['file'] !== $file) continue;
            
            $content = $this->replaceTextWithI18n($content, $mapping);
        }
        
        if ($content !== $originalContent) {
            // Backup do arquivo original
            copy($file, $file . '.backup');
            file_put_contents($file, $content);
            
            return true;
        }
        
        return false;
    }
    
    private function replaceTextWithI18n($content, $mapping) 
    {
        $text = $mapping['original_text'];
        $key = $mapping['suggested_key'];
        $cssClass = $mapping['css_class'];
        
        // Padrões de substituição baseados no tipo
        switch ($mapping['type']) {
            case 'html_titles':
                $pattern = '/(<h[1-6][^>]*class="[^"]*' . preg_quote($cssClass) . '[^"]*"[^>]*>)(' . preg_quote($text) . ')(<\/h[1-6]>)/';
                $replacement = '$1$2$3';
                $content = preg_replace($pattern, function($matches) use ($key) {
                    $openTag = $matches[1];
                    $text = $matches[2];
                    $closeTag = $matches[3];
                    
                    // Adicionar data-i18n se não existir
                    if (strpos($openTag, 'data-i18n') === false) {
                        $openTag = str_replace('>', ' data-i18n="' . $key . '">', $openTag);
                    }
                    
                    return $openTag . $text . $closeTag;
                }, $content);
                break;
                
            case 'html_buttons':
                $pattern = '/(<button[^>]*class="[^"]*' . preg_quote($cssClass) . '[^"]*"[^>]*>)(' . preg_quote($text) . ')(<\/button>)/';
                $content = preg_replace($pattern, function($matches) use ($key) {
                    $openTag = $matches[1];
                    $text = $matches[2];
                    $closeTag = $matches[3];
                    
                    if (strpos($openTag, 'data-i18n') === false) {
                        $openTag = str_replace('>', ' data-i18n="' . $key . '">', $openTag);
                    }
                    
                    return $openTag . $text . $closeTag;
                }, $content);
                break;
                
            case 'placeholder_text':
                $pattern = '/placeholder\s*=\s*[\'"]' . preg_quote($text) . '[\'"]/';
                $replacement = 'placeholder="' . $text . '" data-i18n="' . $key . '"';
                $content = preg_replace($pattern, $replacement, $content);
                break;
        }
        
        return $content;
    }
    
    public function generateI18nJS($mappings) 
    {
        $translations = [
            'pt' => [],
            'en' => [],
            'es' => []
        ];
        
        foreach ($mappings as $mapping) {
            $keyParts = explode('.', $mapping['suggested_key']);
            
            // Criar estrutura hierárquica
            $this->setNestedValue($translations['pt'], $keyParts, $mapping['original_text']);
            $this->setNestedValue($translations['en'], $keyParts, '[EN] ' . $mapping['original_text']);
            $this->setNestedValue($translations['es'], $keyParts, '[ES] ' . $mapping['original_text']);
        }
        
        return json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    private function setNestedValue(&$array, $keys, $value) 
    {
        $current = &$array;
        
        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }
        
        $current = $value;
    }
}
?>
```

---

## 📊 **CoverageAnalyzer.php**

### **Função:** Analisar cobertura de tradução e identificar pendências

```php
<?php
/**
 * Analisa cobertura de tradução e gera relatórios
 */
class CoverageAnalyzer 
{
    public function analyzeProject($projectPath) 
    {
        $extractor = new TextExtractor();
        $texts = $extractor->extractFromDirectory($projectPath);
        
        $analysis = [
            'total_texts' => count($texts),
            'by_type' => $this->groupByType($texts),
            'by_file' => $this->groupByFile($texts),
            'priority_texts' => $this->getPriorityTexts($texts),
            'estimated_effort' => $this->estimateEffort($texts)
        ];
        
        return $analysis;
    }
    
    public function generateReport($analysis) 
    {
        $report = "# Relatório de Cobertura I18n\n\n";
        
        $report .= "## Resumo Geral\n";
        $report .= "- **Total de textos encontrados:** " . $analysis['total_texts'] . "\n";
        $report .= "- **Esforço estimado:** " . $analysis['estimated_effort'] . " horas\n\n";
        
        $report .= "## Por Tipo de Elemento\n";
        foreach ($analysis['by_type'] as $type => $count) {
            $report .= "- **{$type}:** {$count} textos\n";
        }
        
        $report .= "\n## Por Arquivo\n";
        foreach ($analysis['by_file'] as $file => $count) {
            $report .= "- **{$file}:** {$count} textos\n";
        }
        
        $report .= "\n## Textos Prioritários\n";
        foreach ($analysis['priority_texts'] as $text) {
            $report .= "- `{$text['text']}` ({$text['file']}:{$text['line']})\n";
        }
        
        return $report;
    }
    
    private function estimateEffort($texts) 
    {
        // Estimativa baseada em complexidade
        $hours = 0;
        
        foreach ($texts as $text) {
            switch ($text['type']) {
                case 'html_titles':
                    $hours += 0.1; // 6 minutos por título
                    break;
                case 'html_buttons':
                    $hours += 0.05; // 3 minutos por botão
                    break;
                case 'php_messages':
                    $hours += 0.2; // 12 minutos por mensagem
                    break;
                default:
                    $hours += 0.1;
            }
        }
        
        // Overhead de setup e testes
        $hours += 8; // 1 dia de setup
        
        return round($hours, 1);
    }
}
?>
```

---

## 🚀 **MigrationRunner.php**

### **Função:** Script principal que executa todo o processo de migração

```php
<?php
/**
 * Script principal para migração completa para i18n
 */
class MigrationRunner 
{
    private $projectPath;
    private $outputPath;
    
    public function __construct($projectPath, $outputPath = null) 
    {
        $this->projectPath = $projectPath;
        $this->outputPath = $outputPath ?: $projectPath . '/i18n-migration';
    }
    
    public function run() 
    {
        echo "🚀 Iniciando migração para i18n...\n\n";
        
        // Fase 1: Extração
        echo "📍 Fase 1: Extraindo textos...\n";
        $extractor = new TextExtractor();
        $texts = $extractor->extractFromDirectory($this->projectPath);
        echo "✅ {count($texts)} textos extraídos\n\n";
        
        // Fase 2: Mapeamento
        echo "📍 Fase 2: Mapeando chaves...\n";
        $mapper = new KeyMapper();
        $mappings = $mapper->mapTextsToKeys($texts);
        echo "✅ {count($mappings)} mapeamentos criados\n\n";
        
        // Fase 3: Transformação
        echo "📍 Fase 3: Aplicando transformações...\n";
        $transformer = new CodeTransformer();
        $files = $this->getProjectFiles();
        $transformedFiles = 0;
        
        foreach ($files as $file) {
            if ($transformer->applyI18nAttributes($file, $mappings)) {
                $transformedFiles++;
            }
        }
        echo "✅ {$transformedFiles} arquivos transformados\n\n";
        
        // Fase 4: Geração de traduções
        echo "📍 Fase 4: Gerando arquivos de tradução...\n";
        $translationsJson = $transformer->generateI18nJS($mappings);
        file_put_contents($this->outputPath . '/translations.json', $translationsJson);
        echo "✅ Arquivo de traduções gerado\n\n";
        
        // Fase 5: Análise e relatório
        echo "📍 Fase 5: Gerando relatório...\n";
        $analyzer = new CoverageAnalyzer();
        $analysis = $analyzer->analyzeProject($this->projectPath);
        $report = $analyzer->generateReport($analysis);
        file_put_contents($this->outputPath . '/migration-report.md', $report);
        echo "✅ Relatório gerado\n\n";
        
        echo "🎉 Migração concluída!\n";
        echo "📊 Verifique o relatório em: {$this->outputPath}/migration-report.md\n";
        echo "🌐 Arquivos de tradução em: {$this->outputPath}/translations.json\n";
    }
}

// Uso do script
if (php_sapi_name() === 'cli') {
    $projectPath = $argv[1] ?? getcwd();
    $runner = new MigrationRunner($projectPath);
    $runner->run();
}
?>
```

---

## 📝 **Como Usar**

### **Execução Manual:**
```bash
# Extrair textos de um diretório
php scripts/i18n/TextExtractor.php /path/to/project

# Executar migração completa
php scripts/i18n/MigrationRunner.php /path/to/project

# Analisar cobertura atual
php scripts/i18n/CoverageAnalyzer.php /path/to/project
```

### **Integração com Composer:**
```json
{
    "scripts": {
        "i18n:extract": "php scripts/i18n/TextExtractor.php",
        "i18n:analyze": "php scripts/i18n/CoverageAnalyzer.php",
        "i18n:migrate": "php scripts/i18n/MigrationRunner.php"
    }
}
```

---

**Objetivo:** Fornecer automação completa para quando chegar o momento de implementar internacionalização, reduzindo o trabalho manual de 80% para 20%.