﻿using Newtonsoft.Json;

namespace ControleEstoque.DTO
{
    public class UsuarioDTO
    {
        public int Id { get; set; }

        public string Nome { get; set; }

        public string Sobrenome { get; set; }

        public string Email { get; set; }

        public string Senha { get; set; }
    }
}
