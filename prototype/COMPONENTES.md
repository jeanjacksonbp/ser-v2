# Sistema Modular de Componentes - Protótipo SER v2

## 📁 Estrutura de Arquivos

```
prototype/
├── components/
│   ├── header.html      # Cabeçalho comum
│   ├── sidebar.html     # Menu lateral com toggle integrado
│   └── footer.html      # Rodapé comum
├── assets/
│   ├── css/app.css      # Estilos principais
│   └── js/components.js # Carregador de componentes
├── template.html        # Template base para novas páginas
├── index.html          # Dashboard (sistema não-modular)
├── comites.html        # Comitês (sistema modular)
└── kpis.html           # KPIs (sistema modular)
```

## 🔧 Como Usar

### 1. Criando Nova Página
```html
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sua Página · SER v2</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/app.css" />
</head>
<body data-page="nome-da-pagina">
  
  <!-- Header será carregado aqui -->
  <div id="header-placeholder"></div>

  <div class="container-fluid">
    <div class="row">
      
      <!-- Sidebar será carregado aqui -->
      <div id="sidebar-placeholder"></div>
      
      <!-- Seu conteúdo único aqui -->
      <main class="col-12 col-lg-9 col-xl-10 main-content p-3 p-md-4">
        <h1>Conteúdo da sua página</h1>
        
        <!-- Footer será carregado aqui -->
        <div id="footer-placeholder"></div>
      </main>
    </div>
  </div>

  <script src="assets/js/components.js"></script>
</body>
</html>
```

### 2. Identificando Página Ativa
- Use `data-page="nome-da-pagina"` no `<body>`
- Adicione `data-page="nome-da-pagina"` nos links do sidebar
- O script automaticamente marca o link como ativo

## 🎯 Vantagens

### Para o Protótipo:
- ✅ Componentes reutilizáveis
- ✅ Facilita manutenção
- ✅ Consistência visual
- ✅ Navegação dinâmica

### Para Migração PHP:
- ✅ Estrutura igual ao projeto final
- ✅ Componentes já separados
- ✅ Lógica de navegação definida
- ✅ Fácil conversão para includes PHP

## 🔄 Migração para PHP

Os componentes serão facilmente convertidos:

```php
// No projeto PHP final
<?php include 'resources/views/layouts/header.php'; ?>
<?php include 'resources/views/layouts/sidebar.php'; ?>
<!-- Conteúdo da página -->
<?php include 'resources/views/layouts/footer.php'; ?>
```

## 📝 Próximos Passos

1. **Manter**: Sistema atual não-modular para testes rápidos
2. **Implementar**: Sistema modular para novas páginas
3. **Migrar**: Páginas existentes gradualmente
4. **Integrar**: Componentes no projeto PHP final

**Recomendação**: Use o sistema modular para novas páginas e mantenha as atuais para testes.