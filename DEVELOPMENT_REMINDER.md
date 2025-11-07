# Lembrete de Desenvolvimento - Sistema I18n

## 🎯 **IMPORTANTE: Leia Antes de Desenvolver o Projeto PHP**

Este arquivo é um **lembrete crítico** sobre as diretrizes estabelecidas para facilitar futura internacionalização.

---

## 📋 **Checklist Obrigatório para Cada Feature**

### **Antes de Começar Qualquer Desenvolvimento:**
- [ ] Li as diretrizes em `docs/development-guidelines/`
- [ ] Entendi os padrões de MessageHelper
- [ ] Conheço as classes CSS semânticas
- [ ] Sei evitar hardcoding de textos

### **Durante o Desenvolvimento:**
- [ ] Uso `MessageHelper::success()` para mensagens
- [ ] Aplico classes `.page-title`, `.action-save`, etc.
- [ ] Evito `echo "Texto hardcoded"`
- [ ] Mantenho consistência de nomenclatura

### **Antes de Commitar:**
- [ ] Nenhum texto hardcoded em PHP/JS
- [ ] Classes CSS são semânticas
- [ ] Mensagens seguem padrões estabelecidos
- [ ] Código está preparado para I18n

---

## 🚨 **REGRAS DE OURO**

### **❌ NUNCA FAZER:**
```php
// ❌ Textos hardcoded
echo "Usuário criado com sucesso!";
alert("Erro ao salvar!");
throw new Exception("Email inválido");

// ❌ Classes por aparência
<span class="text-blue">Status</span>
<div class="margin-top-20">Conteúdo</div>

// ❌ Mensagens espalhadas
if (!$user) return "Usuário não encontrado";
```

### **✅ SEMPRE FAZER:**
```php
// ✅ MessageHelper
echo Messages::success('user_created');
echo Messages::error('email_invalid');
throw new Exception(Messages::validation('email_format'));

// ✅ Classes semânticas
<span class="status-label">Status</span>
<button class="action-save">Salvar</button>
<h1 class="page-title">Dashboard</h1>

// ✅ Mensagens centralizadas
return $this->redirectWithSuccess('/users', 'user_created');
```

---

## 🎨 **Templates de Código Correto**

### **Controller Pattern:**
```php
class UserController extends BaseController 
{
    use HasMessages;
    
    public function store(Request $request) 
    {
        $user = User::create($request->validated());
        
        return $this->redirectWithSuccess(
            '/users', 
            'user_created', 
            ['name' => $user->name]
        );
    }
    
    public function destroy(User $user) 
    {
        $user->delete();
        
        return $this->redirectWithSuccess('/users', 'user_deleted');
    }
}
```

### **View Pattern:**
```html
<div class="page-container">
    <header class="page-header">
        <h1 class="page-title">Lista de Usuários</h1>
        <button class="btn btn-primary action-create">Criar Novo</button>
    </header>
    
    <main class="page-content">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="table-header-name">Nome</th>
                        <th class="table-header-email">Email</th>
                        <th class="table-header-actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="table-cell-name"><?= $user->name ?></td>
                        <td class="table-cell-email"><?= $user->email ?></td>
                        <td class="table-cell-actions">
                            <button class="btn btn-sm action-edit">Editar</button>
                            <button class="btn btn-sm action-delete">Excluir</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
```

### **JavaScript Pattern:**
```javascript
// ✅ Receber mensagens do PHP
const messages = <?= json_encode(Messages::getJSMessages()) ?>;

function confirmDelete(userName) {
    return confirm(messages.confirm_delete.replace(':name', userName));
}

function showSuccess(message) {
    toast.success(messages[message] || message);
}

// ✅ Não hardcodar textos
// ❌ alert("Operação realizada!");
// ✅ showSuccess('operation_completed');
```

---

## 📁 **Estrutura de Arquivos Recomendada**

```
src/
├── Core/
│   ├── Messages/
│   │   ├── MessageHelper.php          # ← IMPLEMENTAR PRIMEIRO
│   │   ├── ValidationMessages.php
│   │   └── HasMessages.php            # ← TRAIT PARA CONTROLLERS
│   └── Http/
│       └── Controllers/
│           └── BaseController.php
├── Controllers/
│   ├── UserController.php
│   ├── DashboardController.php
│   └── ...
└── Views/
    ├── layouts/
    │   ├── app.php                    # ← USAR CLASSES SEMÂNTICAS
    │   └── components/
    └── pages/
        ├── users/
        └── dashboard/

resources/
├── css/
│   ├── app.css
│   └── semantic.css                   # ← CLASSES PADRONIZADAS
└── js/
    ├── app.js
    └── messages.js                    # ← MENSAGENS PARA JS
```

---

## 🎯 **Implementação Prioritária**

### **1. MessageHelper (PRIMEIRO)**
```php
// src/Core/Messages/MessageHelper.php
class MessageHelper {
    // Implementar conforme message-templates.md
}
```

### **2. HasMessages Trait**
```php
// src/Core/Messages/HasMessages.php
trait HasMessages {
    // Implementar conforme i18n-preparation.md
}
```

### **3. CSS Semântico**
```css
/* resources/css/semantic.css */
.page-title { }
.action-save { }
.nav-dashboard { }
/* Conforme css-semantic-patterns.md */
```

---

## 🚀 **Benefícios de Seguir Essas Diretrizes**

### **Imediatos:**
- ✅ Código mais organizado e consistente
- ✅ Manutenção facilitada
- ✅ Padrões uniformes em toda equipe
- ✅ Menos bugs relacionados a textos

### **Futuros (Quando I18n for Necessário):**
- ✅ **80% do trabalho já feito**
- ✅ **Migração em 2 semanas** ao invés de 2 meses
- ✅ **Scripts automáticos** fazem trabalho pesado
- ✅ **ROI máximo** no desenvolvimento

---

## 📞 **Em Caso de Dúvidas**

### **Consultar:**
1. `docs/development-guidelines/i18n-preparation.md`
2. `docs/development-guidelines/message-templates.md`
3. `docs/development-guidelines/css-semantic-patterns.md`

### **Perguntas Frequentes:**
- **"Posso usar texto hardcoded só dessa vez?"** → ❌ NÃO. Use MessageHelper sempre.
- **"Classes CSS por aparência são mais rápidas"** → ❌ NÃO. Use semânticas sempre.
- **"Isso não vai atrasar o desenvolvimento?"** → ❌ NÃO. São padrões naturais.

---

## ⚡ **Ação Imediata**

### **Antes de Escrever Qualquer Código:**
1. **Implementar MessageHelper** seguindo message-templates.md
2. **Criar trait HasMessages** seguindo i18n-preparation.md  
3. **Definir classes CSS semânticas** seguindo css-semantic-patterns.md
4. **Configurar estrutura de pastas** conforme documentação

### **A Partir de Agora:**
- 🎯 **Todo texto** passa pelo MessageHelper
- 🎨 **Toda classe CSS** é semântica
- 📋 **Todo controller** usa HasMessages
- 🔍 **Todo commit** segue os padrões

---

**LEMBRETE FINAL:** Estes padrões não são "preparação para I18n", são **boas práticas de desenvolvimento** que coincidentemente facilitam I18n. O código fica melhor independente de tradução futura.

**💡 DICA:** Imprima este arquivo e mantenha na mesa durante desenvolvimento inicial!