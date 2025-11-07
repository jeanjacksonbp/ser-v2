# Índice de Diretrizes de Desenvolvimento

## 📚 **Documentação Completa para I18n Futura**

Esta pasta contém toda a documentação e diretrizes necessárias para desenvolvimento do projeto PHP principal com preparação para futura internacionalização.

---

## 📋 **Documentos Disponíveis**

### 1. **[i18n-preparation.md](./i18n-preparation.md)**
**Diretrizes gerais de desenvolvimento preparado para I18n**
- Princípios fundamentais
- Estrutura recomendada para projeto PHP
- Diretrizes de código (PHP, HTML, JS)
- Padrões de nomenclatura
- Checklist para cada feature

### 2. **[message-templates.md](./message-templates.md)**
**Banco de mensagens padronizadas**
- Mensagens de sistema (CRUD, validação, auth)
- Botões e ações padrão
- Labels e títulos comuns
- Mensagens específicas do SER
- Template de implementação PHP

### 3. **[css-semantic-patterns.md](./css-semantic-patterns.md)**
**Padrões de CSS semântico para I18n**
- Classes identificadoras por contexto
- Convenções de nomenclatura
- Mapeamento CSS → data-i18n
- Templates HTML recomendados
- Classes específicas do SER

### 4. **[automation-scripts.md](./automation-scripts.md)**
**Scripts de automação para migração**
- TextExtractor.php - extrai textos do código
- KeyMapper.php - mapeia textos para chaves
- CodeTransformer.php - aplica data-i18n
- CoverageAnalyzer.php - analisa cobertura
- MigrationRunner.php - executa migração completa

---

## 🎯 **Como Usar Esta Documentação**

### **Durante o Desenvolvimento (Agora)**
1. Consulte **i18n-preparation.md** para padrões de código
2. Use **message-templates.md** para mensagens consistentes
3. Aplique **css-semantic-patterns.md** nas interfaces
4. Mantenha **checklist** de cada feature

### **Quando Decidir Internacionalizar (Futuro)**
1. Execute scripts de **automation-scripts.md**
2. Revise mapeamentos automáticos gerados
3. Complete traduções faltantes
4. Teste sistema multilíngue

---

## 🚀 **Fluxo de Trabalho Recomendado**

### **Desenvolvimento Normal (Português)**
```
1. Criar nova feature
2. Usar MessageHelper para textos
3. Aplicar classes CSS semânticas
4. Seguir padrões de nomenclatura
5. Documentar decisões específicas
```

### **Preparação para I18n (Quando Necessário)**
```
1. Executar TextExtractor
2. Revisar mapeamentos sugeridos
3. Executar CodeTransformer
4. Validar transformações
5. Completar traduções
```

---

## 📊 **Benefícios da Abordagem**

### ✅ **Durante Desenvolvimento**
- **Zero overhead** - desenvolvimento natural em português
- **Código organizado** - mensagens centralizadas
- **Consistência** - padrões uniformes
- **Manutenibilidade** - fácil localizar e alterar textos

### ✅ **Na Futura Internacionalização**
- **80% automático** - scripts fazem trabalho pesado
- **Mapeamento inteligente** - sugestões baseadas em contexto
- **Backup automático** - preserva código original
- **Relatórios detalhados** - visibilidade total do processo

---

## 🔧 **Integração com Projeto PHP**

### **Estrutura de Arquivos Sugerida**
```
src/
├── Core/
│   ├── Messages/
│   │   ├── MessageHelper.php      # Implementar conforme message-templates.md
│   │   └── ValidationMessages.php
│   └── I18n/                      # Para futura implementação
│       ├── TranslationManager.php
│       └── LanguageDetector.php
├── Controllers/
│   └── BaseController.php         # Usar trait HasMessages
└── Views/
    └── components/                # Aplicar css-semantic-patterns.md

resources/
├── lang/                          # Para futuras traduções
├── css/
│   └── semantic.css              # Classes padronizadas
└── js/
    └── messages.js               # Mensagens para JS

scripts/
└── i18n/                         # Scripts de automation-scripts.md
    ├── TextExtractor.php
    ├── KeyMapper.php
    └── MigrationRunner.php
```

### **Implementação Imediata**
```php
// 1. Criar MessageHelper conforme message-templates.md
class MessageHelper { ... }

// 2. Trait para controllers conforme i18n-preparation.md
trait HasMessages { ... }

// 3. CSS semântico conforme css-semantic-patterns.md
.page-title, .action-save, .nav-dashboard, etc.
```

---

## 🎓 **Exemplos Práticos**

### **Controller com Boas Práticas**
```php
class UserController extends BaseController 
{
    use HasMessages;
    
    public function create() 
    {
        // ✅ Usar MessageHelper
        $message = Messages::success('user_created');
        
        // ✅ Não hardcoded
        // ❌ echo "Usuário criado!";
        
        return $this->redirectWithSuccess('/users', 'user_created');
    }
}
```

### **Template com Classes Semânticas**
```html
<!-- ✅ Classes identificáveis -->
<h1 class="page-title">Lista de Usuários</h1>
<button class="btn action-create">Criar Novo</button>

<!-- ❌ Classes por aparência -->
<!-- <h1 class="text-blue big-font">Lista de Usuários</h1> -->
```

### **JavaScript com Mensagens Centralizadas**
```javascript
// ✅ Mensagens do PHP
const messages = <?= json_encode(Messages::getJSMessages()) ?>;
confirm(messages.confirm_delete);

// ❌ Hardcoded
// confirm("Tem certeza?");
```

---

## 📈 **Evolução do Sistema**

### **Fase 1: Desenvolvimento (Atual)**
- Aplicar padrões desta documentação
- Desenvolver em português naturalmente
- Manter consistência de mensagens

### **Fase 2: Preparação (Quando Necessário)**
- Executar scripts de análise
- Validar cobertura de textos
- Planejar cronograma de tradução

### **Fase 3: Implementação (Migração)**
- Executar transformação automática
- Revisar mapeamentos gerados
- Testar funcionalidade

### **Fase 4: Tradução (Finalização)**
- Completar traduções faltantes
- Validar interface multilíngue
- Deploy para produção

---

## 🎯 **Lembretes Importantes**

### **Para Desenvolvedores**
- 📝 Sempre usar MessageHelper para textos
- 🎨 Aplicar classes CSS semânticas
- 🔍 Evitar hardcoding de strings
- 📋 Seguir padrões de nomenclatura

### **Para Project Managers**
- 📊 Esta documentação reduz 80% do esforço de I18n
- ⏱️ Migração estimada em 2 semanas quando necessário
- 💰 Custo de internacionalização drasticamente reduzido
- 🚀 Time-to-market acelerado para mercados internacionais

---

**Objetivo Final:** Desenvolver o projeto PHP principal seguindo essas diretrizes para que a futura internacionalização seja um processo rápido, automático e confiável.