// Função para confirmar a ação de editar o imóvel
function confirmarCadastroImovel(event) {
    event.preventDefault(); // Impede o comportamento padrão do link

    // Exibir o SweetAlert com a confirmação
    Swal.fire({
        title: 'Você tem certeza que deseja cadastrar um novo imóvel?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, cadastrar!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o cadastro de imóvel
            window.location.href = event.target.closest('a').getAttribute('href');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe a mensagem de cancelamento
            Swal.fire({
                title: 'Cadastro cancelado',
                text: 'Você cancelou o cadastro do novo imóvel.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}

function editarImovel(event) {
    event.preventDefault(); // Impede o comportamento padrão do link
    
    // Obtém o href do link pai (que é o <a>)
    var link = event.target.closest('a').getAttribute('href');
    Swal.fire({
        title: 'Tem certeza que deseja editar este imóvel?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, editar!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o link
            window.location.href = link; // Redirecionamento correto para o link
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe o alerta
            Swal.fire({
                title: 'Edição cancelada',
                text: 'Você cancelou a edição do imóvel.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}

// Função para confirmar a ação de excluir o imóvel
function excluirImovel(event) {
    event.preventDefault();  // Impede o comportamento padrão (seguindo o link)
    Swal.fire({
        title: 'Tem certeza que deseja excluir este imóvel? Esta ação não pode ser desfeita!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Obtém o href do link clicado e redireciona para a URL
            window.location.href = event.target.closest('a').href;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            exibirErro('erroExcluir', 'Exclusão cancelada pelo usuário.');
        }
    });
}

// Função para confirmar a ação de reservar o imóvel
function reservarImovel(event) {
    event.preventDefault(); // Impede o comportamento padrão do link
    // Obtém o href do link pai (que é o <a>)
    var link = event.target.closest('a').getAttribute('href');
    Swal.fire({
        title: 'Tem certeza que deseja reservar este imóvel?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, reservar!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o link
            window.location.href = link; // Redirecionamento correto para o link
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe o alerta
            Swal.fire({
                title: 'Reserva cancelada',
                text: 'Você cancelou a reserva do imóvel.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}

function editarUsuario(event) {
    event.preventDefault(); // Impede o comportamento padrão do link
    var link = event.target.closest('a').getAttribute('href');
    Swal.fire({
        title: 'Tem certeza que deseja editar este usuário?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, editar!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o link
            window.location.href = link; // Redirecionamento correto para o link
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe o alerta
            Swal.fire({
                title: 'Edição cancelada',
                text: 'Você cancelou a edição do usuário.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}

function excluirUsuario(event) {
    event.preventDefault();  // Impede o comportamento padrão (seguindo o link)

    Swal.fire({
        title: 'Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Obtém o href do link
            var link = event.target.closest('a').getAttribute('href');
            
            // Redireciona para o link
            window.location.href = link;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            exibirErro('erroExcluir', 'Exclusão cancelada.');
        }
    });
}


function editarCliente(event) {
    event.preventDefault(); // Impede o comportamento padrão do link
    var link = event.target.closest('a').getAttribute('href');
    Swal.fire({
        title: 'Tem certeza que deseja editar este cliente?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, editar!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o link
            window.location.href = link; // Redirecionamento correto para o link
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe o alerta
            Swal.fire({
                title: 'Edição cancelada',
                text: 'Você cancelou a edição do cliente.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}


function excluirCliente(event) {
    event.preventDefault();  // Impede o comportamento padrão (seguindo o link)

    Swal.fire({
        title: 'Tem certeza que deseja excluir este cliente? Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Obtém o href do link
            var link = event.target.closest('a').getAttribute('href');
            
            // Redireciona para o link
            window.location.href = link;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            exibirErro('erroExcluir', 'Exclusão cancelada.');
        }
    });
}



function aprovarVenda(event) {
    event.preventDefault(); // Impede o comportamento padrão do link
    var link = event.target.closest('a').getAttribute('href');
    Swal.fire({
        title: 'Deseja aprovar a venda?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, Selecionar comprador!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, redireciona para o link
            window.location.href = link; // Redirecionamento correto para o link
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Se cancelado, exibe o alerta
            Swal.fire({
                title: 'Aprovação cancelada',
                text: 'Você cancelou a aprovação da venda.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}



function confirmarLogout(event, logoutUrl) {
    event.preventDefault(); // Impede o comportamento padrão do link
    Swal.fire({
        title: 'Deseja sair?',
        text: 'Você será desconectado do sistema.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, sair',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireciona para o logout se confirmado
            window.location.href = logoutUrl;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Exibe uma mensagem caso o logout seja cancelado
            Swal.fire({
                title: 'Logout cancelado',
                text: 'Você permaneceu conectado.',
                icon: 'info',
                confirmButtonText: 'Ok'
            });
        }
    });
}

