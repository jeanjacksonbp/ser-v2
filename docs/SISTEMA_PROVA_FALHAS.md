# 🛡️ SISTEMA À PROVA DE FALHAS - SER v2.0

## ⚠️ REGRAS ABSOLUTAS - NUNCA QUEBRAR

### 🚨 **REGRA 1: TEMPLATE SAGRADO**
**NUNCA, JAMAIS** altere este template base. Toda página nova DEVE seguir EXATAMENTE:

```php
<?php
/**
 * [NOME DA PÁGINA] - SER v2.0
 * Template SAGRADO - NÃO ALTERAR
 */

// ✅ STEP 1: Bootstrap (SEMPRE primeiro)
require_once __DIR__ . '/../../bootstrap/app.php';

// ✅ STEP 2: Auth Check (NUNCA usar $_SESSION direto)
$guard->requireAuth();

// ✅ STEP 3: Permission Check (SEMPRE obrigatório)
$guard->requirePermission('NOME_PERMISSAO_AQUI');

// ✅ STEP 4: Load Data (SOMENTE através do Guard)
$user = $guard->getUser();    // ✅ SEMPRE objeto
$actor = $guard->getActor();  // ✅ SEMPRE objeto ou null

// ✅ STEP 5: Verificações adicionais (se necessário)
$canEdit = $guard->hasPermission('recurso.edit');

// ✅ STEP 6: Preparar dados (NUNCA acessar banco direto)
$pageData = [
    'user' => $user,           // ✅ Já é objeto
    'actor' => $actor,         // ✅ Já é objeto
    'canEdit' => $canEdit
];

// ✅ STEP 7: Include View
include __DIR__ . '/../../resources/views/pages/NOME_ARQUIVO.php';
?>
```

---

## 🔒 **REGRAS DE TIPOS - NUNCA CONFUNDIR**

### ✅ **O QUE SEMPRE É OBJETO:**
```php
$user = $guard->getUser();     // stdClass object
$actor = $guard->getActor();   // ActorContext object ou null

// ACESSO CORRETO:
$userId = $user->id;           // ✅ SEMPRE ->
$userName = $user->nome;       // ✅ SEMPRE ->
$userEmail = $user->email;     // ✅ SEMPRE ->

$actorRoles = $actor->roles;   // ✅ SEMPRE ->
$empresaId = $actor->empresaId; // ✅ SEMPRE ->
```

### ❌ **O QUE NUNCA FAZER:**
```php
$userId = $user['id'];         // ❌ NUNCA [] em objects
$userName = $_SESSION['nome']; // ❌ NUNCA $_SESSION direto
$roles = $GLOBALS['actor'];    // ❌ NUNCA $GLOBALS direto
```

---

## 📋 **CHECKLIST OBRIGATÓRIO ANTES DE CADA PÁGINA**

### 🔍 **ANTES DE COMEÇAR:**
- [ ] Li o template sagrado acima?
- [ ] Identifiquei a permissão necessária?
- [ ] Verifiquei se não vou quebrar as regras de tipo?

### 🔨 **DURANTE DESENVOLVIMENTO:**
- [ ] Usei EXATAMENTE o template sagrado?
- [ ] Não acessei $_SESSION diretamente?
- [ ] Não acessei $GLOBALS diretamente?
- [ ] Não fiz queries diretas no banco?
- [ ] Usei -> para objetos (user, actor)?

### ✅ **ANTES DE TESTAR:**
- [ ] Revisei se segui as regras absolutas?
- [ ] Testei com diferentes tipos de usuário?
- [ ] Verifiquei se não há hardcoding de IDs/empresas?

---

## 🚫 **COMANDOS PROIBIDOS - NUNCA USAR**

### ❌ **ACESSO DIRETO (PROIBIDO):**
```php
// NUNCA FAÇA ISSO:
if (!isset($_SESSION['user_id'])) { ... }           // ❌ Use $guard->requireAuth()
$stmt = $pdo->prepare("SELECT * FROM usuarios"); // ❌ Use $guard->getUser()
$userId = $_SESSION['user_id'];                   // ❌ Use $user->id
$roles = $GLOBALS['actor']->roles;               // ❌ Use $actor->roles
```

### ✅ **SEMPRE USAR (CORRETO):**
```php
// SEMPRE FAÇA ASSIM:
$guard->requireAuth();                    // ✅ Sistema definitivo
$user = $guard->getUser();               // ✅ Dados seguros
$actor = $guard->getActor();             // ✅ Contexto completo
$canDo = $guard->hasPermission('acao');  // ✅ Verificação segura
```

---

## 🎯 **DEBUGGING SEGURO**

### 🔍 **Para debuggar sem quebrar o sistema:**
```php
// ✅ Debug seguro:
if ($actor && $actor->hasRole('SuperAdmin')) {
    echo "<pre>DEBUG:\n";
    echo "User ID: " . $user->id . "\n";
    echo "Roles: " . implode(', ', $actor->roles) . "\n";
    echo "Empresa: " . $actor->empresaId . "\n";
    echo "</pre>";
}
```

### ❌ **NUNCA debuggar assim:**
```php
// ❌ Debug perigoso:
var_dump($_SESSION);         // Expõe dados sensíveis
var_dump($GLOBALS);         // Quebra encapsulamento
echo $user['nome'];         // Erro de tipo
```

---

## 🏗️ **CRIAÇÃO DE NOVAS PÁGINAS - PROCESSO**

### 1️⃣ **PREPARAÇÃO:**
```bash
# 1. Definir permissão necessária
PERMISSAO="diagnostico.financeiro.view"

# 2. Definir nome da página
NOME_PAGINA="diagnostico-analise-financeira"
```

### 2️⃣ **CONTROLLER:**
```php
# Arquivo: public/diagnostico-analise-financeira.php
# Copiar EXATAMENTE o template sagrado
# Substituir apenas:
# - NOME_PERMISSAO_AQUI → diagnostico.financeiro.view
# - NOME_ARQUIVO → diagnostico-analise-financeira
```

### 3️⃣ **VIEW:**
```php
# Arquivo: resources/views/pages/diagnostico-analise-financeira.php
# Usar variáveis $user, $actor já preparadas
# NUNCA acessar $_SESSION ou $GLOBALS
```

### 4️⃣ **ROTEAMENTO:**
```php
# Adicionar em public/index.php:
if ($uri === '/diagnostico-analise-financeira') {
  require __DIR__ . '/diagnostico-analise-financeira.php'; exit;
}
```

---

## 🛠️ **MANUTENÇÃO DO SISTEMA**

### 🔄 **Se algo quebrar:**
1. **NÃO criar atalho temporário**
2. **Verificar se seguiu o template sagrado**
3. **Verificar se respeitou as regras de tipo**
4. **Usar apenas métodos do $guard**

### 🎯 **Para expandir funcionalidades:**
1. **Adicionar método no Guard se necessário**
2. **NUNCA contornar o sistema**
3. **Sempre manter compatibilidade com template**

---

## 📞 **SUPORTE RÁPIDO**

### ❓ **Dúvidas comuns:**
- **"Como pego dados do usuário?"** → `$user = $guard->getUser();`
- **"Como verifico permissão?"** → `$guard->hasPermission('acao');`
- **"Como força autenticação?"** → `$guard->requireAuth();`
- **"Erro de tipo object/array?"** → Use `->` para objetos, não `[]`

### 🚨 **Em caso de erro:**
1. Verificar se seguiu template sagrado
2. Verificar se não quebrou regras de tipo
3. Verificar se não usou comandos proibidos
4. Consultar este documento

---

**🛡️ SISTEMA À PROVA DE FALHAS ATIVADO!**
**Siga religiosamente estas regras e nunca mais teremos problemas!**