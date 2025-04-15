function toggleFooter() {
    var footer = document.getElementById("mainFooter");
    var button = document.getElementById("toggleFooter").querySelector("button");

    if (footer.classList.contains("hidden")) {
        footer.classList.remove("hidden");
        button.innerHTML = "Ocultar Rodapé";

        // Rolar a página para exibir o rodapé completamente
        setTimeout(() => {
            footer.scrollIntoView({ behavior: "smooth", block: "end" });
        }, 300);
    } else {
        footer.classList.add("hidden");
        button.innerHTML = "Exibir Rodapé";
    }
}

window.abrirModalCupom = function (imagem, descricao, link, cupom, observacao) {
    const modal = document.getElementById('cupomModal');
    const modalLogo = document.getElementById('modal-logo');
    const modalDescricao = document.getElementById('modal-descricao');
    const modalCupom = document.getElementById('cupom-codigo');
    const modalLink = document.getElementById('modal-link');
    const modalObservacao = document.getElementById('modal-observacao');
    const botaoCopiarIr = document.getElementById('botao-copiar-e-ir');

    modal.style.display = 'block';
    modalLogo.src = imagem;
    modalDescricao.textContent = descricao;
    modalCupom.textContent = cupom;
    modalLink.href = link.startsWith('http') ? link : 'https://' + link;
    modalObservacao.textContent = observacao;

    window.open(modalLink.href, '_blank');

    if (botaoCopiarIr) {
        botaoCopiarIr.onclick = function (event) {
            event.preventDefault();
            navigator.clipboard.writeText(modalCupom.textContent)
                .then(() => {
                    window.open(modalLink.href, '_blank');
                })
                .catch(err => console.error('Erro ao copiar o cupom:', err));
        };
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const scrollTopBtn = document.getElementById("scrollTopBtn");
    const navOpener = document.querySelector(".nav-opener");

    // Exibir o botão quando a página rolar para baixo
    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add("show");
        } else {
            scrollTopBtn.classList.remove("show");
        }
    });

    if (navOpener && nav) {
        navOpener.addEventListener("click", function (e) {
            e.preventDefault();
            document.body.classList.toggle("nav-active");
        });
    
        document.addEventListener("click", function (e) {
            if (!nav.contains(e.target) && !navOpener.contains(e.target)) {
                document.body.classList.remove("nav-active");
            }
        });
    } 

    // Rolar suavemente para o topo ao clicar
    scrollTopBtn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    window.onclick = function (event) {
        const modal = document.getElementById('cupomModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    document.querySelector('.close')?.addEventListener('click', () => {
        document.getElementById('cupomModal').style.display = 'none';
    });
});
