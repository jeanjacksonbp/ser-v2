# Diretrizes de Desenvolvimento - Preparação para I18n

## 📋 **Visão Geral**

Este documento contém todas as diretrizes e boas práticas identificadas durante o desenvolvimento do protótipo que devem ser seguidas no **projeto PHP principal** para facilitar a futura internacionalização.

## 🎯 **Princípios Fundamentais**

### 1. **Desenvolvimento Português-First**
- Desenvolver todas as interfaces inicialmente em português
- Manter textos claros e consistentes
- Documentar decisões de nomenclatura

### 2. **Preparação Invisível para I18n**
- Estruturar código pensando na futura tradução
- Evitar hardcoding de textos em lógica
- Usar padrões que facilitarão automação

---

## 🏗️ **Estrutura Recomendada para o Projeto PHP**

```
src/
├── Core/
│   ├── I18n/                    # Sistema de tradução (futuro)
│   │   ├── TranslationManager.php
│   │   ├── LanguageDetector.php
│   │   └── TextExtractor.php    # Para migração automática
│   └── ...
├── Views/
│   ├── components/
│   │   ├── messages/            # Componentes de mensagem
│   │   └── forms/               # Componentes de formulário
│   └── pages/
└── ...

resources/
├── lang/                        # Traduções (futuro)
│   ├── pt/
│   ├── en/
│   └── es/
├── js/
│   └── i18n/                    # Scripts de internacionalização
└── views/

database/
├── migrations/
│   └── create_translations_table.php  # Migração para i18n
└── ...

docs/
├── development-guidelines/       # Este diretório
├── i18n/                        # Documentação de internacionalização
└── ...
```

---

## 💻 **Diretrizes de Código PHP**

### 1. **Mensagens e Textos**

#### ✅ **FAZER:**
```php
// Usar constantes ou métodos para mensagens
class UserController 
{
    private const MESSAGES = [
        'user_created' => 'Usuário criado com sucesso!',
        'user_not_found' => 'Usuário não encontrado.',
        'validation_error' => 'Dados inválidos fornecidos.'
    ];
    
    public function create() 
    {
        // Lógica...
        return $this->success(self::MESSAGES['user_created']);
    }
}

// Ou usando um sistema de mensagens centralizado
class MessageHelper 
{
    public static function success($key, $params = []) 
    {
        return self::getMessage('success.' . $key, $params);
    }
    
    public static function error($key, $params = []) 
    {
        return self::getMessage('error.' . $key, $params);
    }
}
```

#### ❌ **EVITAR:**
```php
// Textos hardcoded espalhados no código
if (!$user) {
    throw new Exception("Usuário não encontrado"); // ❌
}

echo "Dados salvos com sucesso!"; // ❌
```

### 2. **Templates e Views**

#### ✅ **FAZER:**
```php
<!-- Usar helper para textos dinâmicos -->
<div class="alert alert-success">
    <?= Messages::success('user_created') ?>
</div>

<!-- Usar classes semânticas -->
<button class="btn btn-primary action-save">Salvar</button>
<span class="status-label">Status</span>

<!-- Preparar para data-attributes futuros -->
<h1 class="page-title">Dashboard</h1> <!-- Futuro: data-i18n="nav.dashboard" -->
```

#### ❌ **EVITAR:**
```php
<!-- Textos misturados com HTML -->
<div>Usuário <?= $user->name ?> foi criado!</div> <!-- ❌ -->

<!-- Classes por aparência -->
<span class="text-blue">Status</span> <!-- ❌ -->
```

### 3. **Validação e Formulários**

#### ✅ **FAZER:**
```php
class UserValidator 
{
    private const VALIDATION_MESSAGES = [
        'name_required' => 'Nome é obrigatório.',
        'email_invalid' => 'Email deve ter formato válido.',
        'password_min_length' => 'Senha deve ter pelo menos :min caracteres.'
    ];
    
    public function validate($data) 
    {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors['name'] = self::VALIDATION_MESSAGES['name_required'];
        }
        
        return $errors;
    }
}
```

### 4. **JavaScript e Frontend**

#### ✅ **FAZER:**
```javascript
// Usar constantes para mensagens JS
const MESSAGES = {
    CONFIRM_DELETE: 'Tem certeza que deseja excluir?',
    LOADING: 'Carregando...',
    ERROR_GENERIC: 'Ocorreu um erro inesperado.'
};

// Ou receber do PHP
const messages = <?= json_encode($jsMessages) ?>;

function confirmDelete() {
    return confirm(MESSAGES.CONFIRM_DELETE);
}
```

#### ❌ **EVITAR:**
```javascript
// Textos hardcoded em JS
if (confirm("Tem certeza?")) { // ❌
    alert("Excluído com sucesso!"); // ❌
}
```

---

## 🎨 **Diretrizes de Interface**

### 1. **Nomenclatura Consistente**

#### **Botões e Ações:**
```
Salvar / Cancelar
Criar / Editar / Excluir
Adicionar / Remover
Confirmar / Voltar
Exportar / Importar
```

#### **Estados e Status:**
```
Ativo / Inativo
Pendente / Concluído / Cancelado
Sucesso / Erro / Aviso / Informação
```

#### **Navegação:**
```
Dashboard
Usuários
Relatórios  
Configurações
Sair
```

### 2. **Mensagens Padronizadas**

#### **Sucesso:**
```
"[Item] criado com sucesso!"
"[Item] atualizado com sucesso!"
"[Item] excluído com sucesso!"
"Operação realizada com sucesso!"
```

#### **Erro:**
```
"[Item] não encontrado."
"Erro ao processar solicitação."
"Dados inválidos fornecidos."
"Acesso negado."
```

#### **Confirmação:**
```
"Tem certeza que deseja excluir [item]?"
"Esta ação não pode ser desfeita."
"Deseja continuar?"
```

---

## 🔧 **Ferramentas e Utilitários**

### 1. **Classe Helper para Mensagens (PHP)**

```php
<?php
class MessageHelper 
{
    private static $messages = [
        'success' => [
            'created' => ':item criado com sucesso!',
            'updated' => ':item atualizado com sucesso!',
            'deleted' => ':item excluído com sucesso!'
        ],
        'error' => [
            'not_found' => ':item não encontrado.',
            'validation' => 'Dados inválidos fornecidos.',
            'generic' => 'Ocorreu um erro inesperado.'
        ],
        'confirm' => [
            'delete' => 'Tem certeza que deseja excluir :item?',
            'action' => 'Deseja continuar com esta ação?'
        ]
    ];
    
    public static function get($type, $key, $params = []) 
    {
        $message = self::$messages[$type][$key] ?? '';
        
        foreach ($params as $param => $value) {
            $message = str_replace(":$param", $value, $message);
        }
        
        return $message;
    }
    
    public static function success($key, $params = []) 
    {
        return self::get('success', $key, $params);
    }
    
    public static function error($key, $params = []) 
    {
        return self::get('error', $key, $params);
    }
    
    public static function confirm($key, $params = []) 
    {
        return self::get('confirm', $key, $params);
    }
}
?>
```

### 2. **Trait para Controllers**

```php
<?php
trait HasMessages 
{
    protected function successMessage($key, $params = []) 
    {
        return MessageHelper::success($key, $params);
    }
    
    protected function errorMessage($key, $params = []) 
    {
        return MessageHelper::error($key, $params);
    }
    
    protected function setFlashMessage($type, $message) 
    {
        $_SESSION['flash'][$type] = $message;
    }
    
    protected function redirectWithSuccess($url, $key, $params = []) 
    {
        $this->setFlashMessage('success', $this->successMessage($key, $params));
        header("Location: $url");
        exit;
    }
}
?>
```

---

## 📊 **Mapeamento para Futura Automação**

### 1. **Padrões de Extração**

```php
// Padrões que o script de extração deve reconhecer:

// Mensagens em arrays/constantes
private const MESSAGES = [...];
private static $messages = [...];

// Calls para helpers
MessageHelper::success('key')
Messages::get('type.key')

// Textos em templates
<h1 class="page-title">Texto</h1>
<button class="btn action-*">Texto</button>
```

### 2. **Estrutura de Chaves Sugerida**

```
nav.dashboard
nav.users
nav.reports

common.save
common.cancel
common.edit
common.delete

messages.success.created
messages.success.updated
messages.error.not_found
messages.error.validation

pages.dashboard.title
pages.users.create_title
pages.users.list_title

forms.user.name_label
forms.user.email_label
forms.user.password_label
```

---

## 🚀 **Plano de Migração Futura**

### Fase 1: Preparação (Durante desenvolvimento PHP)
- [ ] Implementar MessageHelper
- [ ] Usar padrões consistentes
- [ ] Documentar novas mensagens

### Fase 2: Extração (Quando decidir internacionalizar)
- [ ] Script para extrair textos
- [ ] Mapeamento automático para chaves
- [ ] Geração de arquivos de tradução

### Fase 3: Aplicação (Automática)
- [ ] Substituir textos por chamadas i18n
- [ ] Adicionar data-i18n nos templates
- [ ] Configurar sistema de tradução

### Fase 4: Tradução (Manual/Assistida)
- [ ] Traduzir chaves identificadas
- [ ] Validar traduções
- [ ] Testes multilíngues

---

## 📝 **Checklist para Cada Feature**

Ao desenvolver nova funcionalidade, verificar:

- [ ] Textos estão em constantes/helpers?
- [ ] Mensagens seguem padrões estabelecidos?
- [ ] Classes CSS são semânticas?
- [ ] JavaScript não tem textos hardcoded?
- [ ] Validações usam mensagens centralizadas?
- [ ] Nomenclatura é consistente com o resto do sistema?

---

**Objetivo:** Garantir que quando chegar o momento de internacionalizar, 80% do trabalho já esteja feito através dessas boas práticas aplicadas desde o início.