<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque Central</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f3ea;
            --bg-soft: #fff9ed;
            --ink: #122025;
            --ink-soft: #49606a;
            --primary: #0d7a74;
            --primary-strong: #0a615d;
            --accent: #ca5c1b;
            --line: #d9dfd2;
            --ok: #2d8a4e;
            --danger: #b53c2b;
            --card: rgba(255, 255, 255, 0.83);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Space Grotesk", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 14%, #ccebe4 0%, transparent 38%),
                radial-gradient(circle at 88% 14%, #ffe4bf 0%, transparent 32%),
                linear-gradient(180deg, var(--bg-soft) 0%, var(--bg) 100%);
        }

        .shell {
            width: min(1120px, 92vw);
            margin: 2rem auto;
            display: grid;
            gap: 1rem;
        }

        .hero {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 1.6rem;
            background: linear-gradient(130deg, rgba(13, 122, 116, 0.16), rgba(202, 92, 27, 0.18));
            box-shadow: 0 14px 36px rgba(27, 42, 45, 0.1);
            animation: rise 0.7s ease;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.38);
            right: -100px;
            bottom: -150px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.36rem 0.66rem;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(120deg, var(--primary), var(--accent));
        }

        h1 {
            margin: 0.9rem 0 0.3rem;
            font-size: clamp(1.5rem, 2.6vw, 2.25rem);
            line-height: 1.1;
        }

        .sub {
            margin: 0;
            color: var(--ink-soft);
            max-width: 70ch;
        }

        .grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(12, 1fr);
        }

        .panel {
            background: var(--card);
            backdrop-filter: blur(5px);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(28, 45, 43, 0.08);
            animation: rise 0.6s ease;
        }

        .stats {
            grid-column: span 12;
            padding: 1rem;
            display: grid;
            gap: 0.8rem;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .metric {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0.9rem;
            background: rgba(255, 255, 255, 0.74);
        }

        .metric small {
            display: block;
            color: var(--ink-soft);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.35rem;
        }

        .metric strong {
            font-size: clamp(1.2rem, 2.2vw, 1.55rem);
        }

        .composer {
            grid-column: span 4;
            padding: 1rem;
        }

        .title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.85rem;
            gap: 0.5rem;
        }

        .title h2 {
            margin: 0;
            font-size: 1.02rem;
        }

        .mono {
            font-family: "IBM Plex Mono", monospace;
            font-size: 0.75rem;
            color: var(--ink-soft);
        }

        form {
            display: grid;
            gap: 0.72rem;
        }

        label {
            display: grid;
            gap: 0.35rem;
            font-size: 0.86rem;
            color: var(--ink-soft);
        }

        input {
            width: 100%;
            border: 1px solid #c6d2c4;
            border-radius: 12px;
            padding: 0.65rem 0.75rem;
            background: #fff;
            font: inherit;
            color: var(--ink);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 122, 116, 0.15);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-top: 0.2rem;
        }

        button {
            border: 0;
            border-radius: 12px;
            padding: 0.6rem 0.86rem;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(120deg, var(--primary), var(--primary-strong));
        }

        .btn-secondary {
            color: var(--ink);
            background: #e9eee2;
        }

        .btn-danger {
            color: #fff;
            background: var(--danger);
        }

        .list {
            grid-column: span 8;
            padding: 1rem;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 0.7rem;
        }

        .table-wrap {
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.75);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
        }

        th, td {
            text-align: left;
            padding: 0.72rem 0.8rem;
            border-bottom: 1px solid #e4eadf;
            font-size: 0.9rem;
        }

        th {
            font-size: 0.74rem;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: 0.09em;
        }

        tr {
            transition: background-color 0.2s ease;
        }

        tr:hover {
            background: #f7fbf4;
        }

        .row-actions {
            display: flex;
            gap: 0.45rem;
            flex-wrap: wrap;
        }

        .status {
            margin-top: 0.65rem;
            min-height: 1.2rem;
            font-size: 0.86rem;
            color: var(--ink-soft);
        }

        .status.ok {
            color: var(--ok);
        }

        .status.error {
            color: var(--danger);
        }

        .empty {
            text-align: center;
            padding: 1.6rem;
            color: var(--ink-soft);
        }

        footer {
            text-align: center;
            color: var(--ink-soft);
            font-size: 0.78rem;
            margin-top: 0.2rem;
        }

        @media (max-width: 980px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .composer,
            .list {
                grid-column: span 12;
            }
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="hero">
            <span class="pill">Projeto Estoque</span>
            <h1>Painel de Gerenciamento de Estoque</h1>
            <p class="sub">
                Interface conectada na API REST de produtos. Cadastre itens, acompanhe volume total e valor financeiro do estoque em tempo real.
            </p>
        </section>

        <section class="grid">
            <article class="panel stats">
                <div class="metric">
                    <small>Total de produtos</small>
                    <strong id="total-products">0</strong>
                </div>
                <div class="metric">
                    <small>Quantidade em estoque</small>
                    <strong id="total-quantity">0</strong>
                </div>
                <div class="metric">
                    <small>Valor total estimado</small>
                    <strong id="total-value">R$ 0,00</strong>
                </div>
            </article>

            <article class="panel composer">
                <div class="title">
                    <h2 id="form-title">Cadastrar produto</h2>
                    <span class="mono">POST /api/products</span>
                </div>

                <form id="product-form">
                    <label>
                        Nome
                        <input id="nome" name="nome" type="text" maxlength="255" required placeholder="Ex: Mouse sem fio">
                    </label>
                    <label>
                        Quantidade
                        <input id="quantidade" name="quantidade" type="number" min="0" step="1" required placeholder="0">
                    </label>
                    <label>
                        Preco
                        <input id="preco" name="preco" type="number" min="0" step="0.01" required placeholder="0.00">
                    </label>
                    <div class="actions">
                        <button type="submit" class="btn-primary" id="submit-btn">Salvar produto</button>
                        <button type="button" class="btn-secondary" id="cancel-btn" hidden>Cancelar edicao</button>
                    </div>
                </form>
                <div id="status" class="status"></div>
            </article>

            <article class="panel list">
                <div class="toolbar">
                    <div class="title" style="margin: 0;">
                        <h2>Produtos cadastrados</h2>
                        <span class="mono">GET /api/products</span>
                    </div>
                    <button type="button" class="btn-secondary" id="refresh-btn">Atualizar</button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Preco</th>
                                <th>Acoes</th>
                            </tr>
                        </thead>
                        <tbody id="products-body">
                            <tr>
                                <td colspan="5" class="empty">Carregando produtos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <footer>
            Laravel v<?php echo e(Illuminate\Foundation\Application::VERSION); ?> | PHP v<?php echo e(PHP_VERSION); ?>

        </footer>
    </main>

    <script>
        const apiBase = '/api/products';
        const form = document.getElementById('product-form');
        const cancelBtn = document.getElementById('cancel-btn');
        const refreshBtn = document.getElementById('refresh-btn');
        const statusEl = document.getElementById('status');
        const bodyEl = document.getElementById('products-body');
        const submitBtn = document.getElementById('submit-btn');
        const formTitle = document.getElementById('form-title');

        const totalProductsEl = document.getElementById('total-products');
        const totalQuantityEl = document.getElementById('total-quantity');
        const totalValueEl = document.getElementById('total-value');

        let editingId = null;
        let products = [];

        const money = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });

        function setStatus(message, type = '') {
            statusEl.textContent = message;
            statusEl.className = `status ${type}`.trim();
        }

        function resetForm() {
            form.reset();
            editingId = null;
            formTitle.textContent = 'Cadastrar produto';
            submitBtn.textContent = 'Salvar produto';
            cancelBtn.hidden = true;
        }

        function updateStats(list) {
            const totalProducts = list.length;
            const totalQuantity = list.reduce((acc, p) => acc + Number(p.quantidade || 0), 0);
            const totalValue = list.reduce((acc, p) => acc + (Number(p.quantidade || 0) * Number(p.preco || 0)), 0);

            totalProductsEl.textContent = String(totalProducts);
            totalQuantityEl.textContent = String(totalQuantity);
            totalValueEl.textContent = money.format(totalValue);
        }

        function renderTable(list) {
            if (!list.length) {
                bodyEl.innerHTML = '<tr><td colspan="5" class="empty">Nenhum produto cadastrado ainda.</td></tr>';
                return;
            }

            bodyEl.innerHTML = list.map((product) => `
                <tr>
                    <td>${product.id}</td>
                    <td>${escapeHtml(product.nome)}</td>
                    <td>${Number(product.quantidade)}</td>
                    <td>${money.format(Number(product.preco))}</td>
                    <td>
                        <div class="row-actions">
                            <button class="btn-secondary" data-action="edit" data-id="${product.id}">Editar</button>
                            <button class="btn-danger" data-action="delete" data-id="${product.id}">Excluir</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        async function loadProducts() {
            try {
                const response = await fetch(apiBase, { headers: { 'Accept': 'application/json' } });
                const payload = await response.json();

                if (!response.ok) {
                    throw new Error(payload.message || 'Erro ao carregar produtos.');
                }

                products = Array.isArray(payload.data) ? payload.data : [];
                renderTable(products);
                updateStats(products);
            } catch (error) {
                setStatus(error.message, 'error');
                bodyEl.innerHTML = '<tr><td colspan="5" class="empty">Nao foi possivel carregar os produtos.</td></tr>';
                updateStats([]);
            }
        }

        async function saveProduct(event) {
            event.preventDefault();

            const payload = {
                nome: form.nome.value.trim(),
                quantidade: Number(form.quantidade.value),
                preco: Number(form.preco.value)
            };

            if (!payload.nome) {
                setStatus('Informe o nome do produto.', 'error');
                return;
            }

            const isEditing = editingId !== null;
            const url = isEditing ? `${apiBase}/${editingId}` : apiBase;
            const method = isEditing ? 'PUT' : 'POST';

            try {
                setStatus(isEditing ? 'Atualizando produto...' : 'Criando produto...');

                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        const message = Array.isArray(firstError) ? firstError[0] : data.message;
                        throw new Error(message || 'Erro de validacao.');
                    }
                    throw new Error(data.message || 'Falha ao salvar produto.');
                }

                setStatus(data.message || 'Operacao realizada com sucesso.', 'ok');
                resetForm();
                await loadProducts();
            } catch (error) {
                setStatus(error.message, 'error');
            }
        }

        function startEdit(id) {
            const product = products.find((item) => Number(item.id) === Number(id));
            if (!product) {
                setStatus('Produto nao encontrado para edicao.', 'error');
                return;
            }

            editingId = product.id;
            form.nome.value = product.nome;
            form.quantidade.value = product.quantidade;
            form.preco.value = product.preco;

            formTitle.textContent = `Editar produto #${product.id}`;
            submitBtn.textContent = 'Salvar alteracao';
            cancelBtn.hidden = false;
            setStatus('Modo de edicao ativado.');
        }

        async function deleteProduct(id) {
            const confirmed = window.confirm('Deseja realmente excluir este produto?');
            if (!confirmed) {
                return;
            }

            try {
                const response = await fetch(`${apiBase}/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Falha ao excluir produto.');
                }

                setStatus(data.message || 'Produto removido com sucesso.', 'ok');

                if (editingId === Number(id)) {
                    resetForm();
                }

                await loadProducts();
            } catch (error) {
                setStatus(error.message, 'error');
            }
        }

        bodyEl.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-action]');
            if (!button) {
                return;
            }

            const id = Number(button.dataset.id);
            if (!id) {
                return;
            }

            if (button.dataset.action === 'edit') {
                startEdit(id);
                return;
            }

            if (button.dataset.action === 'delete') {
                deleteProduct(id);
            }
        });

        cancelBtn.addEventListener('click', () => {
            resetForm();
            setStatus('Edicao cancelada.');
        });

        refreshBtn.addEventListener('click', async () => {
            setStatus('Atualizando lista...');
            await loadProducts();
            setStatus('Lista atualizada.', 'ok');
        });

        form.addEventListener('submit', saveProduct);

        loadProducts();
    </script>
</body>
</html>
<?php /**PATH C:\PROJETOS\php-projeto\resources\views/welcome.blade.php ENDPATH**/ ?>