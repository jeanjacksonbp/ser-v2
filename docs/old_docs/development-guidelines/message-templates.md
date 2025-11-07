# Template de Mensagens Padronizadas

## 📝 **Banco de Mensagens Padrão**

Este arquivo contém todas as mensagens padronizadas que devem ser usadas no projeto PHP principal.

---

## 🎯 **Mensagens de Sistema**

### **Ações de CRUD**
```php
// Criação
'item_created' => ':item criado com sucesso!',
'user_created' => 'Usuário criado com sucesso!',
'report_created' => 'Relatório criado com sucesso!',

// Atualização  
'item_updated' => ':item atualizado com sucesso!',
'user_updated' => 'Usuário atualizado com sucesso!',
'profile_updated' => 'Perfil atualizado com sucesso!',

// Exclusão
'item_deleted' => ':item excluído com sucesso!',
'user_deleted' => 'Usuário excluído com sucesso!',

// Busca/Listagem
'item_not_found' => ':item não encontrado.',
'user_not_found' => 'Usuário não encontrado.',
'no_results' => 'Nenhum resultado encontrado.',
'loading_data' => 'Carregando dados...',
```

### **Validação de Formulários**
```php
// Campos obrigatórios
'field_required' => 'Campo :field é obrigatório.',
'name_required' => 'Nome é obrigatório.',
'email_required' => 'Email é obrigatório.',
'password_required' => 'Senha é obrigatória.',

// Formato/Validação
'email_invalid' => 'Email deve ter formato válido.',
'password_min_length' => 'Senha deve ter pelo menos :min caracteres.',
'password_confirmation' => 'Confirmação de senha não confere.',
'date_invalid' => 'Data deve ter formato válido.',
'number_invalid' => 'Deve ser um número válido.',

// Duplicação
'email_already_exists' => 'Este email já está em uso.',
'username_already_exists' => 'Este nome de usuário já está em uso.',
```

### **Autenticação e Autorização**
```php
// Login
'login_success' => 'Login realizado com sucesso!',
'login_failed' => 'Email ou senha incorretos.',
'account_locked' => 'Conta bloqueada temporariamente.',
'must_login' => 'Você deve fazer login para continuar.',

// Logout
'logout_success' => 'Logout realizado com sucesso!',

// Permissões
'access_denied' => 'Acesso negado.',
'insufficient_permissions' => 'Você não tem permissão para esta ação.',
'admin_required' => 'Acesso restrito a administradores.',
```

### **Operações de Sistema**
```php
// Upload/Download
'file_uploaded' => 'Arquivo enviado com sucesso!',
'file_upload_failed' => 'Falha ao enviar arquivo.',
'file_too_large' => 'Arquivo muito grande. Tamanho máximo: :size.',
'invalid_file_type' => 'Tipo de arquivo não permitido.',

// Import/Export
'data_exported' => 'Dados exportados com sucesso!',
'data_imported' => 'Dados importados com sucesso!',
'export_failed' => 'Falha ao exportar dados.',
'import_failed' => 'Falha ao importar dados.',

// Backup/Restore
'backup_created' => 'Backup criado com sucesso!',
'backup_restored' => 'Backup restaurado com sucesso!',
```

---

## 🔘 **Botões e Ações**

### **Ações Principais**
```php
'save' => 'Salvar',
'cancel' => 'Cancelar',
'submit' => 'Enviar',
'confirm' => 'Confirmar',
'continue' => 'Continuar',
'finish' => 'Finalizar',
```

### **CRUD Operations**
```php
'create' => 'Criar',
'create_new' => 'Criar Novo',
'add' => 'Adicionar',
'edit' => 'Editar',
'update' => 'Atualizar',
'delete' => 'Excluir',
'remove' => 'Remover',
'view' => 'Visualizar',
'details' => 'Detalhes',
```

### **Navegação**
```php
'back' => 'Voltar',
'next' => 'Próximo',
'previous' => 'Anterior',
'close' => 'Fechar',
'home' => 'Início',
'dashboard' => 'Dashboard',
```

### **Filtros e Busca**
```php
'search' => 'Pesquisar',
'filter' => 'Filtrar',
'clear_filters' => 'Limpar Filtros',
'sort' => 'Ordenar',
'export' => 'Exportar',
'import' => 'Importar',
```

---

## ⚠️ **Mensagens de Confirmação**

### **Exclusões**
```php
'confirm_delete' => 'Tem certeza que deseja excluir :item?',
'confirm_delete_user' => 'Tem certeza que deseja excluir este usuário?',
'confirm_delete_multiple' => 'Tem certeza que deseja excluir :count itens selecionados?',
'action_irreversible' => 'Esta ação não pode ser desfeita.',
```

### **Operações Críticas**
```php
'confirm_action' => 'Deseja continuar com esta ação?',
'confirm_changes' => 'Tem certeza que deseja salvar estas alterações?',
'confirm_logout' => 'Deseja sair do sistema?',
'unsaved_changes' => 'Existem alterações não salvas. Deseja continuar?',
```

---

## 🏷️ **Labels e Títulos**

### **Formulários Comuns**
```php
// Usuário
'name' => 'Nome',
'full_name' => 'Nome Completo',
'email' => 'Email',
'password' => 'Senha',
'confirm_password' => 'Confirmar Senha',
'phone' => 'Telefone',
'address' => 'Endereço',

// Datas
'created_at' => 'Criado em',
'updated_at' => 'Atualizado em',
'date' => 'Data',
'start_date' => 'Data Início',
'end_date' => 'Data Término',

// Status
'status' => 'Status',
'active' => 'Ativo',
'inactive' => 'Inativo',
'pending' => 'Pendente',
'completed' => 'Concluído',
'cancelled' => 'Cancelado',
```

### **Navegação Principal**
```php
'dashboard' => 'Dashboard',
'users' => 'Usuários',
'reports' => 'Relatórios',
'settings' => 'Configurações',
'profile' => 'Perfil',
'logout' => 'Sair',

// Submenu Usuários
'user_list' => 'Lista de Usuários',
'create_user' => 'Criar Usuário',
'user_profile' => 'Perfil do Usuário',
'user_permissions' => 'Permissões',
```

---

## 📊 **Estados e Status**

### **Status de Sistema**
```php
'online' => 'Online',
'offline' => 'Offline',
'connecting' => 'Conectando',
'loading' => 'Carregando',
'processing' => 'Processando',
'completed' => 'Concluído',
'failed' => 'Falhou',
```

### **Níveis de Alerta**
```php
'success' => 'Sucesso',
'info' => 'Informação',
'warning' => 'Aviso',
'error' => 'Erro',
'danger' => 'Perigo',
```

---

## 🎯 **Mensagens Específicas do SER**

### **Módulos do Sistema**
```php
// Diagnóstico
'diagnostic' => 'Diagnóstico',
'organizational_diagnostic' => 'Diagnóstico Organizacional',
'diagnostic_completed' => 'Diagnóstico concluído com sucesso!',

// Planejamento
'planning' => 'Planejamento',
'strategic_planning' => 'Planejamento Estratégico',
'goal_created' => 'Meta criada com sucesso!',

// Comitês
'committees' => 'Comitês',
'committee_created' => 'Comitê criado com sucesso!',
'meeting_scheduled' => 'Reunião agendada com sucesso!',

// KPIs
'kpis' => 'KPIs',
'indicator_created' => 'Indicador criado com sucesso!',
'reading_recorded' => 'Leitura registrada com sucesso!',

// Feedback
'feedback' => 'Feedback',
'feedback_submitted' => 'Feedback enviado com sucesso!',
'survey_completed' => 'Pesquisa concluída com sucesso!',

// Avaliação
'evaluation' => 'Avaliação',
'evaluation_completed' => 'Avaliação concluída com sucesso!',
```

### **Termos Específicos**
```php
'participative_management' => 'Gestão Participativa',
'high_performance' => 'Alto Desempenho',
'engagement' => 'Engajamento',
'leadership' => 'Liderança',
'organizational_culture' => 'Cultura Organizacional',
'continuous_improvement' => 'Melhoria Contínua',
```

---

## 🔧 **Como Usar no PHP**

### **Implementação Sugerida:**

```php
<?php
class Messages 
{
    private static $messages = [
        // Incluir todas as mensagens acima organizadas por categoria
        'success' => [...],
        'error' => [...],
        'labels' => [...],
        'buttons' => [...],
        'confirm' => [...],
        'ser_modules' => [...]
    ];
    
    public static function get($category, $key, $params = []) 
    {
        $message = self::$messages[$category][$key] ?? $key;
        
        // Substituir parâmetros :param por valores
        foreach ($params as $param => $value) {
            $message = str_replace(":$param", $value, $message);
        }
        
        return $message;
    }
    
    // Métodos de conveniência
    public static function success($key, $params = []) 
    {
        return self::get('success', $key, $params);
    }
    
    public static function error($key, $params = []) 
    {
        return self::get('error', $key, $params);
    }
    
    public static function label($key) 
    {
        return self::get('labels', $key);
    }
    
    public static function button($key) 
    {
        return self::get('buttons', $key);
    }
}
?>
```

### **Exemplo de Uso:**

```php
// No Controller
$message = Messages::success('user_created');
$confirm = Messages::get('confirm', 'delete_user');

// No Template
<button><?= Messages::button('save') ?></button>
<label><?= Messages::label('name') ?></label>
```

---

**Objetivo:** Manter consistência em todas as mensagens do sistema e facilitar a futura internacionalização através de um vocabulário padronizado.