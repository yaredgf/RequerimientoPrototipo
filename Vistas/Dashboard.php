<?php
/*
 *  Tenes que llenar las variables 
 * 
 * $vista tenes que meterle uno de estos "Usuarios" "Productos" "Proveedores" "Roles"
 * $todos es el array de objetos de la entidad que es, si son usuarios por ejemplo, le metes todos los usuarios (puede ser null)
 */


if (!isset($_SESSION["idUsuario"])) {
    header("Location: index.php?c=index");
    die();
}
if (! isset($vistaActiva)) $vistaActiva = "Dashboard";
$usuarioSesion = isset($_SESSION["usuario"]) ? json_decode($_SESSION["usuario"]) : null;
$usernameDisplay = htmlspecialchars($usuarioSesion->username ?? "Usuario");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root {
            --sb: 200px;
            --bg: #0d0d0d;
            --surface: #161616;
            --surface2: #1f1f1f;
            --accent: #6c5ce7;
            --accent-dim: #2d2457;
            --text: #e8e8e8;
            --text-muted: #888;
            --border: #2a2a2a;
            --radius: 6px;
            --danger: #c0392b;
            --success: #27ae60;
        }
        body {
            font-family: system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
        }
        /* SIDEBAR */
        .sb {
            width: var(--sb);
            background: var(--surface);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            border-right: 1px solid var(--border);
        }
        .sb-brand {
            padding: 20px 16px;
            font-size: 15px;
            font-weight: 600;
            color: var(--accent);
            border-bottom: 1px solid var(--border);
        }
        .sb-nav {
            flex: 1;
            padding: 12px 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .nav-btn {
            display: block;
            width: 100%;
            padding: 9px 12px;
            background: none;
            border: none;
            border-radius: var(--radius);
            color: var(--text-muted);
            font-size: 13.5px;
            text-align: left;
            cursor: pointer;
            transition: background .12s, color .12s;
            text-decoration: none;
        }
        .nav-btn:hover {
            background: var(--surface2);
            color: var(--text);
        }
        .nav-btn.active {
            background: var(--accent-dim);
            color: #fff;
        }
        .sb-footer {
            padding: 12px 8px;
            border-top: 1px solid var(--border);
        }
        .logout-btn {
            display: block;
            width: 100%;
            padding: 9px 12px;
            background: none;
            border: none;
            border-radius: var(--radius);
            color: var(--text-muted);
            font-size: 13.5px;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            transition: background .12s, color .12s;
        }
        .logout-btn:hover {
            background: #2a1515;
            color: #e88;
        }
        /* MAIN */
        .main {
            margin-left: var(--sb);
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            height: 50px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-size: 14px;
            font-weight: 500;
        }
        .topbar-user {
            font-size: 13px;
            color: var(--text-muted);
        }
        .content {
            padding: 24px;
            flex: 1;
        }
        /* CRUD SECTION */
        .sec-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 12px;
        }
        .sec-title {
            font-size: 16px;
            font-weight: 500;
        }
        .sec-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        input.search {
            height: 34px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0 10px;
            color: var(--text);
            font-size: 13px;
            outline: none;
            width: 200px;
            transition: border-color .12s;
        }
        input.search:focus {
            border-color: var(--accent);
        }
        input.search::placeholder {
            color: var(--text-muted);
        }
        .btn {
            height: 34px;
            padding: 0 14px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: opacity .12s;
        }
        .btn:hover {
            opacity: .85;
        }
        .btn-accent {
            background: var(--accent);
            color: #fff;
        }
        .btn-sm {
            height: 28px;
            padding: 0 10px;
            font-size: 12px;
            border-radius: var(--radius);
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--text-muted);
            transition: background .12s, color .12s;
        }
        .btn-sm:hover {
            background: var(--surface);
            color: var(--text);
        }
        .btn-edit:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .btn-off:hover {
            border-color: var(--danger);
            color: var(--danger);
        }
        .btn-on:hover {
            border-color: var(--success);
            color: var(--success);
        }
        /* TABLE */
        .tbl-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background: var(--surface2);
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            padding: 9px 14px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        tbody tr:hover {
            background: var(--surface2);
        }
        tbody td {
            padding: 10px 14px;
            font-size: 13.5px;
            vertical-align: middle;
        }
        .td-actions {
            display: flex;
            gap: 6px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .badge-on {
            background: #0d2b1a;
            color: #4caf7d;
        }
        .badge-off {
            background: #2b0d0d;
            color: #e07070;
        }
        .empty {
            padding: 40px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }
        /* MODAL */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }
        .overlay.open {
            display: flex;
        }
        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 420px;
            padding: 22px;
        }
        .modal-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .modal-title {
            font-size: 15px;
            font-weight: 500;
        }
        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 20px;
            line-height: 1;
            padding: 0 2px;
        }
        .modal-close:hover {
            color: var(--text);
        }
        .fg {
            margin-bottom: 14px;
        }
        .fg label {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 5px;
        }
        .fg input, .fg select {
            width: 100%;
            height: 36px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0 10px;
            color: var(--text);
            font-size: 13.5px;
            outline: none;
            transition: border-color .12s;
            appearance: none;
        }
        .fg select option {
            background: var(--surface2);
        }
        .fg input:focus, .fg select:focus {
            border-color: var(--accent);
        }
        .fg input.err, .fg select.err {
            border-color: var(--danger);
        }
        .ferr {
            font-size: 11px;
            color: var(--danger);
            margin-top: 3px;
            display: none;
        }
        .ferr.show {
            display: block;
        }
        .modal-foot {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 18px;
        }
        .btn-cancel {
            background: var(--surface2);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }
        /* TOAST */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 16px;
            border-radius: var(--radius);
            font-size: 13px;
            display: none;
            z-index: 999;
        }
        .toast.show {
            display: block;
        }
        .toast.ok {
            border-color: var(--success);
            color: #4caf7d;
        }
        .toast.err {
            border-color: var(--danger);
            color: #e07070;
        }
    </style>
</head>
<body>

<aside class="sb">
    <div class="sb-brand">Panel de administrador</div>
    <nav class="sb-nav">
        <a href="./index.php?c=Usuarios" class="nav-btn <?= $vistaActiva === 'Usuarios' ? 'active' : '' ?>">Usuarios</a>
        <a href="./index.php?c=Productos&a=Index" class="nav-btn <?= $vistaActiva === 'Productos' ? 'active' : '' ?>">Productos</a>
        <a href="./index.php?c=Categorias&a=Index" class="nav-btn <?= $vistaActiva === 'Categorias' ? 'active' : '' ?>">Categorías</a>
        <a href="./index.php?c=Proveedores&a=Index" class="nav-btn <?= $vistaActiva === 'Proveedores' ? 'active' : '' ?>">Proveedores</a>
        <a href="./index.php?c=Roles&a=Index" class="nav-btn <?= $vistaActiva === 'Roles' ? 'active' : '' ?>">Roles</a>
    </nav>
    <div class="sb-footer">
        <a href="index.php?c=Usuarios&a=CerrarSesion" class="logout-btn">Cerrar sesión</a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <span class="topbar-title"><? $vistaActiva ?></span>
    </div>

    <div class="content">
        <!-- USUARIOS -->
        <?php if ($vistaActiva === 'Usuarios'): ?>
        <section class="crud-sec">
            <div class="sec-header">
                <span class="sec-title">Usuarios</span>
                <div class="sec-actions">
                    <input class="search" type="text" placeholder="Buscar…" oninput="filtrar('tbl-u',this.value)">
                    <button class="btn btn-accent" onclick="nuevoModal('modal-u','Crear usuario')">+ Crear</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table id="tbl-u">
                    <thead><tr><th>Usuario</th><th>Correo</th><th>Rol</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($todos)): ?>
                            <?php foreach ($todos as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u->getUsername()) ?></td>
                                <td><?= htmlspecialchars($u->getEmail()) ?></td>
                                <td><?= htmlspecialchars($u->getIdTipoUsuario()) ?></td>
                                <td><span class="badge <?= $u->getEstado() == 1 ? 'badge-on' : 'badge-off' ?>"><?= $u->getEstado() == 1 ? 'Activo' : 'Inactivo' ?></span></td>
                                <td><div class="td-actions"><button class="btn-sm btn-edit" onclick="editarUsuario(<?= $u->getId() ?>,'<?= htmlspecialchars($u->getUsername(), ENT_QUOTES) ?>','<?= htmlspecialchars($u->getEmail(), ENT_QUOTES) ?>',<?= $u->getIdTipoUsuario() ?>)">Editar</button><button class="btn-sm <?= $u->getEstado() == 1 ? 'btn-off' : 'btn-on' ?>" onclick="toggleEstado('usuarios',<?= $u->getId() ?>,<?= $u->getEstado() == 1 ? 0 : 1 ?>)"><?= $u->getEstado() == 1 ? 'Desactivar' : 'Activar' ?></button></div></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5"><div class="empty">Sin usuarios registrados</div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <!-- PRODUCTOS -->
        <?php if ($vistaActiva === 'Productos'): ?>
        <section class="crud-sec">
            <div class="sec-header">
                <span class="sec-title">Productos</span>
                <div class="sec-actions">
                    <input class="search" type="text" placeholder="Buscar…" oninput="filtrar('tbl-p',this.value)">
                    <button class="btn btn-accent" onclick="nuevoModal('modal-p','Crear producto')">+ Crear</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table id="tbl-p">
                    <thead><tr><th>Nombre</th><th>Precio</th><th>Proveedor</th><th>Categoría</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($todos)): ?>
                            <?php foreach ($todos as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->getNombre()) ?></td>
                                <td>₡<?= number_format($p->getPrecio(), 2) ?></td>
                                <td><?= htmlspecialchars($p->getProveedor()) ?></td>
                                <td><?= htmlspecialchars($p->getCategoria()) ?></td>
                                <td><span class="badge <?= $p->getEstado() == 1 ? 'badge-on' : 'badge-off' ?>"><?= $p->getEstado() == 1 ? 'Activo' : 'Inactivo' ?></span></td>
                                <td><div class="td-actions"><button class="btn-sm btn-edit" onclick="editarProducto(<?= $p->getId() ?>,'<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>',<?= $p->getPrecio() ?>,'<?= htmlspecialchars($p->getProveedor(), ENT_QUOTES) ?>',<?= $p->getCategoria() ?>)">Editar</button><button class="btn-sm <?= $p->getEstado() == 1 ? 'btn-off' : 'btn-on' ?>" onclick="toggleEstado('productos',<?= $p->getId() ?>,<?= $p->getEstado() == 1 ? 0 : 1 ?>)"><?= $p->getEstado() == 1 ? 'Desactivar' : 'Activar' ?></button></div></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6"><div class="empty">Sin productos registrados</div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <!-- PROVEEDORES -->
        <?php if ($vistaActiva === 'Proveedores'): ?>
        <section class="crud-sec">
            <div class="sec-header">
                <span class="sec-title">Proveedores</span>
                <div class="sec-actions">
                    <input class="search" type="text" placeholder="Buscar…" oninput="filtrar('tbl-prov',this.value)">
                    <button class="btn btn-accent" onclick="nuevoModal('modal-prov','Crear proveedor')">+ Crear</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table id="tbl-prov">
                    <thead><tr><th>Nombre</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($todos)): ?>
                            <?php foreach ($todos as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->getNombre()) ?></td>
                                <td><span class="badge <?= $p->getEstado() == 1 ? 'badge-on' : 'badge-off' ?>"><?= $p->getEstado() == 1 ? 'Activo' : 'Inactivo' ?></span></td>
                                <td><div class="td-actions"><button class="btn-sm btn-edit" onclick="editarProveedor(<?= $p->getId() ?>,'<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>')">Editar</button><button class="btn-sm <?= $p->getEstado() == 1 ? 'btn-off' : 'btn-on' ?>" onclick="toggleEstado('proveedores',<?= $p->getId() ?>,<?= $p->getEstado() == 1 ? 0 : 1 ?>)"><?= $p->getEstado() == 1 ? 'Desactivar' : 'Activar' ?></button></div></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3"><div class="empty">Sin proveedores registrados</div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <!-- CATEGORIAS -->
        <?php if ($vistaActiva === 'Categorias'): ?>
        <section class="crud-sec">
            <div class="sec-header">
                <span class="sec-title">Categorías</span>
                <div class="sec-actions">
                    <input class="search" type="text" placeholder="Buscar…" oninput="filtrar('tbl-cat',this.value)">
                    <button class="btn btn-accent" onclick="nuevoModal('modal-cat','Crear categoría')">+ Crear</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table id="tbl-prov">
                    <thead><tr><th>Nombre</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($todos)): ?>
                            <?php foreach ($todos as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->getNombre()) ?></td>
                                <td><span class="badge <?= $p->getEstado() == 1 ? 'badge-on' : 'badge-off' ?>"><?= $p->getEstado() == 1 ? 'Activo' : 'Inactivo' ?></span></td>
                                <td><div class="td-actions"><button class="btn-sm btn-edit" onclick="editarCategoria(<?= $p->getId() ?>,'<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>')">Editar</button><button class="btn-sm <?= $p->getEstado() == 1 ? 'btn-off' : 'btn-on' ?>" onclick="toggleEstado('categorias',<?= $p->getId() ?>,<?= $p->getEstado() == 1 ? 0 : 1 ?>)"><?= $p->getEstado() == 1 ? 'Desactivar' : 'Activar' ?></button></div></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3"><div class="empty">Sin categorías registrados</div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <!-- ROLES -->
        <?php if ($vistaActiva === 'Roles'): ?>
        <section class="crud-sec">
            <div class="sec-header">
                <span class="sec-title">Roles</span>
                <div class="sec-actions">
                    <input class="search" type="text" placeholder="Buscar…" oninput="filtrar('tbl-r',this.value)">
                    <button class="btn btn-accent" onclick="nuevoModal('modal-r','Crear rol')">+ Crear</button>
                </div>
            </div>
            <div class="tbl-wrap">
                <table id="tbl-r">
                    <thead><tr><th>Nombre</th><th></th></tr></thead>
                    <tbody>
                        <?php if (!empty($todos)): ?>
                            <?php foreach ($todos as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r->getNombre()) ?></td>
                                <td><div class="td-actions"><button class="btn-sm btn-edit" onclick="editarRol(<?= $r->getId() ?>,'<?= htmlspecialchars($r->getNombre(), ENT_QUOTES) ?>')">Editar</button></div></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2"><div class="empty">Sin roles registrados</div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
    </div>
</main>

<!-- MODAL USUARIOS -->
<div class="overlay" id="modal-u">
    <div class="modal">
        <div class="modal-hdr">
            <span class="modal-title" id="modal-u-title">Crear usuario</span>
            <button class="modal-close" onclick="cerrar('modal-u')">&times;</button>
        </div>
        <input type="hidden" id="u-id">
        <div class="fg"><label>Nombre de usuario</label><input type="text" id="u-username" placeholder="ej. jperez"><span class="ferr" id="u-username-err">Campo requerido</span></div>
        <div class="fg"><label>Correo</label><input type="email" id="u-email" placeholder="correo@ejemplo.com"><span class="ferr" id="u-email-err">Correo inválido</span></div>
        <div class="fg"><label>Contraseña</label><input type="password" id="u-pass" placeholder="Mínimo 6 caracteres"><span class="ferr" id="u-pass-err">Mínimo 6 caracteres</span></div>
        <div class="fg"><label>Rol</label>
            <select id="u-rol">
                <option value="">Seleccionar…</option>
                <option value="1">Administrador</option>
                <option value="2">Vendedor</option>
            </select>
            <span class="ferr" id="u-rol-err">Seleccioná un rol</span>
        </div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="cerrar('modal-u')">Cancelar</button>
            <button class="btn btn-accent" onclick="guardarUsuario()">Guardar</button>
        </div>
    </div>
</div>

<!-- MODAL PRODUCTOS -->
<div class="overlay" id="modal-p">
    <div class="modal">
        <div class="modal-hdr">
            <span class="modal-title" id="modal-p-title">Crear producto</span>
            <button class="modal-close" onclick="cerrar('modal-p')">&times;</button>
        </div>
        <input type="hidden" id="p-id">
        <div class="fg"><label>Nombre</label><input type="text" id="p-nombre" placeholder="Nombre del producto"><span class="ferr" id="p-nombre-err">Campo requerido</span></div>
        <div class="fg"><label>Precio (₡)</label><input type="number" id="p-precio" placeholder="0.00" min="0" step="0.01"><span class="ferr" id="p-precio-err">Precio inválido</span></div>
        <div class="fg"><label>ID Proveedor</label><input type="text" id="p-prov" placeholder="ID de proveedor"><span class="ferr" id="p-desc-err">Campo requerido</span></div>
        <div class="fg"><label>ID Categoría</label><input type="text" id="p-cat" placeholder="ID de categoría"><span class="ferr" id="p-cat-err">Campo requerido</span></div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="cerrar('modal-p')">Cancelar</button>
            <button class="btn btn-accent" onclick="guardarProducto()">Guardar</button>
        </div>
    </div>
</div>

<!-- MODAL CATEGORIAS -->
<div class="overlay" id="modal-cat">
    <div class="modal">
        <div class="modal-hdr">
            <span class="modal-title" id="modal-cat-title">Crear categorías</span>
            <button class="modal-close" onclick="cerrar('modal-cat')">&times;</button>
        </div>
        <input type="hidden" id="cat-id">
        <div class="fg"><label>Nombre</label><input type="text" id="cat-nombre" placeholder="Nombre de la categoría"><span class="ferr" id="cat-nombre-err">Campo requerido</span></div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="cerrar('modal-cat')">Cancelar</button>
            <button class="btn btn-accent" onclick="guardarCategoria()">Guardar</button>
        </div>
    </div>
</div>

<!-- MODAL PROVEEDORES -->
<div class="overlay" id="modal-prov">
    <div class="modal">
        <div class="modal-hdr">
            <span class="modal-title" id="modal-prov-title">Crear proveedor</span>
            <button class="modal-close" onclick="cerrar('modal-prov')">&times;</button>
        </div>
        <input type="hidden" id="prov-id">
        <div class="fg"><label>Nombre</label><input type="text" id="prov-nombre" placeholder="Nombre del proveedor"><span class="ferr" id="prov-nombre-err">Campo requerido</span></div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="cerrar('modal-prov')">Cancelar</button>
            <button class="btn btn-accent" onclick="guardarProveedor()">Guardar</button>
        </div>
    </div>
</div>

<!-- MODAL ROLES -->
<div class="overlay" id="modal-r">
    <div class="modal">
        <div class="modal-hdr">
            <span class="modal-title" id="modal-r-title">Crear rol</span>
            <button class="modal-close" onclick="cerrar('modal-r')">&times;</button>
        </div>
        <input type="hidden" id="r-id">
        <div class="fg"><label>Nombre del rol</label><input type="text" id="r-nombre" placeholder="ej. Administrador"><span class="ferr" id="r-nombre-err">Campo requerido</span></div>
        <div class="modal-foot">
            <button class="btn btn-cancel" onclick="cerrar('modal-r')">Cancelar</button>
            <button class="btn btn-accent" onclick="guardarRol()">Guardar</button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
    function filtrar(id, q) {
        document.querySelectorAll('#' + id + ' tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
        });
    }

    function abrir(id) {
        document.getElementById(id).classList.add('open');
    }

    function cerrar(id) {
        document.getElementById(id).classList.remove('open');
        limpiar(id);
    }

    function nuevoModal(id, titulo) {
        document.getElementById(id).querySelectorAll('input:not([type=hidden]),select').forEach(f => f.value = '');
        document.getElementById(id).querySelectorAll('input[type=hidden]').forEach(f => f.value = '');
        document.getElementById(id + '-title').textContent = titulo;
        abrir(id);
    }

    function limpiar(id) {
        document.getElementById(id).querySelectorAll('.ferr').forEach(e => e.classList.remove('show'));
        document.getElementById(id).querySelectorAll('.err').forEach(e => e.classList.remove('err'));
    }

    document.querySelectorAll('.overlay').forEach(o => o.addEventListener('click', e => {
        if (e.target === o) cerrar(o.id);
    }));

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.overlay.open').forEach(o => cerrar(o.id));
    });

    function toast(msg, tipo) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast show ' + (tipo || 'ok');
        setTimeout(() => t.className = 'toast', 2800);
    }

    function setErr(fId, eId) {
        document.getElementById(fId).classList.add('err');
        document.getElementById(eId).classList.add('show');
    }

    function emailOk(e) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);
    }

    function post(url, data, onOk, onFail) {
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
            .then(r => r.json())
            .then(ok => {
                if (ok) onOk();
                else onFail();
            })
            //.catch(() => toast('Error de conexión', 'err'));
    }

    function reload(modal) {
        cerrar(modal);
        setTimeout(() => location.reload(), 700);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

    /* USUARIOS */
    function editarUsuario(id, u, e, r) {
        document.getElementById('u-id').value = id;
        document.getElementById('u-username').value = u;
        document.getElementById('u-email').value = e;
        document.getElementById('u-pass').value = '';
        document.getElementById('u-pass').placeholder = 'Dejar en blanco para no cambiar';
        document.getElementById('u-rol').value = r;
        document.getElementById('modal-u-title').textContent = 'Editar usuario';
        abrir('modal-u');
    }

    function guardarUsuario() {
        limpiar('modal-u');
        const id = document.getElementById('u-id').value;
        const username = document.getElementById('u-username').value.trim();
        const email = document.getElementById('u-email').value.trim();
        const pass = document.getElementById('u-pass').value;
        const rol = document.getElementById('u-rol').value;
        let ok = true;
        if (!username) {
            setErr('u-username', 'u-username-err');
            ok = false;
        }
        if (!emailOk(email)) {
            setErr('u-email', 'u-email-err');
            ok = false;
        }
        if (!id && pass.length < 6) {
            setErr('u-pass', 'u-pass-err');
            ok = false;
        }
        if (!rol) {
            setErr('u-rol', 'u-rol-err');
            ok = false;
        }
        if (!ok) return;
        post('index.php?c=Usuarios&a=Crear', { id, username, email, pass, rol },
            () => {
                toast(id ? 'Usuario actualizado' : 'Usuario creado');
                reload('modal-u');
            },
            () => toast('No se pudo guardar', 'err')
        );
    }

    /* TOGGLE ESTADO */
    function toggleEstado(entidad, id, estado) {
        post('index.php?c=' + entidad + '&a=Activar', { id, estado },
            () => {
                toast(estado == 1 ? 'Activado' : 'Desactivado');
                setTimeout(() => location.reload(), 700);
            },
            () => toast('No se pudo cambiar el estado', 'err')
        );
    }

    /* PRODUCTOS */
    function editarProducto(id, n, pr, prov, cat) {
        document.getElementById('p-id').value = id;
        document.getElementById('p-nombre').value = n;
        document.getElementById('p-prov').value = prov;
        document.getElementById('p-precio').value = pr;
        document.getElementById('p-cat').value = cat;
        document.getElementById('modal-p-title').textContent = 'Editar producto';
        abrir('modal-p');
    }

    function guardarProducto() {
        limpiar('modal-p');
        const id = document.getElementById('p-id').value;
        const nombre = document.getElementById('p-nombre').value.trim();
        const prov = document.getElementById('p-prov').value.trim();
        const precio = parseFloat(document.getElementById('p-precio').value);
        const cat = document.getElementById('p-cat').value.trim();
        let ok = true;
        if (!nombre) {
            setErr('p-nombre', 'p-nombre-err');
            ok = false;
        }
        if (!prov) {
            setErr('p-prov', 'p-desc-err');
            ok = false;
        }
        if (isNaN(precio) || precio < 0) {
            setErr('p-precio', 'p-precio-err');
            ok = false;
        }
        if (!cat) {
            setErr('p-cat', 'p-cat-err');
            ok = false;
        }
        if (!ok) return;
        post('index.php?c=Productos&a=Crear', { id, nombre, prov, precio, cat },
            () => {
                toast(id ? 'Producto actualizado' : 'Producto creado');
                reload('modal-p');
            },
            () => toast('No se pudo guardar', 'err')
        );
    }

    /* CATEGORIAS */
    function editarCategoria(id, n) {
        document.getElementById('cat-id').value = id;
        document.getElementById('cat-nombre').value = n;
        document.getElementById('modal-cat-title').textContent = 'Editar categoría';
        abrir('modal-cat');
    }

    function guardarCategoria() {
        limpiar('modal-cat');
        const id = document.getElementById('cat-id').value;
        const nombre = document.getElementById('cat-nombre').value.trim();
        let ok = true;
        if (!nombre) {
            setErr('cat-nombre', 'cat-nombre-err');
            ok = false;
        }
        if (!ok) return;
        post('index.php?c=Categorias&a=Crear', { id, nombre },
            () => {
                toast(id ? 'Categoria actualizada' : 'Categoria creada');
                reload('modal-cat');
            },
            () => toast('No se pudo guardar', 'err')
        );
    }

    /* PROVEEDORES */
    function editarProveedor(id, n) {
        document.getElementById('prov-id').value = id;
        document.getElementById('prov-nombre').value = n;
        document.getElementById('modal-prov-title').textContent = 'Editar proveedor';
        abrir('modal-prov');
    }

    function guardarProveedor() {
        limpiar('modal-prov');
        const id = document.getElementById('prov-id').value;
        const nombre = document.getElementById('prov-nombre').value.trim();
        let ok = true;
        if (!nombre) {
            setErr('prov-nombre', 'prov-nombre-err');
            ok = false;
        }
        if (!ok) return;
        post('index.php?c=Proveedores&a=Crear', { id, nombre },
            () => {
                toast(id ? 'Proveedor actualizado' : 'Proveedor creado');
                reload('modal-prov');
            },
            () => toast('No se pudo guardar', 'err')
        );
    }

    /* ROLES */
    function editarRol(id, n) {
        document.getElementById('r-id').value = id;
        document.getElementById('r-nombre').value = n;
        document.getElementById('modal-r-title').textContent = 'Editar rol';
        abrir('modal-r');
    }

    function guardarRol() {
        limpiar('modal-r');
        const id = document.getElementById('r-id').value;
        const nombre = document.getElementById('r-nombre').value.trim();
        let ok = true;
        if (!nombre) {
            setErr('r-nombre', 'r-nombre-err');
            ok = false;
        }
        if (!ok) return;
        post('index.php?c=Roles&a=Crear', { id, nombre },
            () => {
                toast(id ? 'Rol actualizado' : 'Rol creado');
                reload('modal-r');
            },
            () => toast('No se pudo guardar', 'err')
        );
    }
</script>
</body>
</html>