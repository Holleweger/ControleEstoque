using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class UsuarioController : ControllerBase
    {
        private readonly DBContext DBContext;

        public UsuarioController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }


        [HttpGet("ValidarUsuario/{email}/{senha}")]
        public async Task<HttpStatusCode> ValidarUsuario(string email, string senha)
        {
            UsuarioDTO usuario = await DBContext.Usuario.Select(
                    s => new UsuarioDTO
                    {
                        Email = s.Email,
                        Senha = s.Senha,
                    })
                .FirstOrDefaultAsync(s => s.Email == email && s.Senha == senha);

            if (usuario == null)
            {
                return HttpStatusCode.Unauthorized;
            }
            else
            {
                return HttpStatusCode.Accepted;
            }
        }

        [HttpPost("CadastrarUsuario")]
        public async Task<HttpStatusCode> CadastrarUsuario(UsuarioDTO usuario)
        {
            var entity = new Usuario()
            {
                Nome = usuario.Nome,
                Sobrenome = usuario.Sobrenome,
                Email = usuario.Email,
                Senha = usuario.Senha,
            };

            DBContext.Usuario.Add(entity);
            await DBContext.SaveChangesAsync();

            return HttpStatusCode.Created;
        }
    }
}
