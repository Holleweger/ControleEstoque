using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class ProdutoController : ControllerBase
    {
        private readonly DBContext DBContext;

        public ProdutoController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }

        [HttpGet("GetProduto")]
        public async Task<ActionResult<List<ProdutoDTO>>> Get()
        {
            var List = await DBContext.Produto.Select(
                s => new ProdutoDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                }
            ).ToListAsync();

            if (List.Count < 0)
            {
                return NotFound();
            }
            else
            {
                return List;
            }
        }

        [HttpGet("GetProdutoById/{id}")]
        public async Task<ActionResult<ProdutoDTO>> GetProutoById(int Id)
        {
            ProdutoDTO produto = await DBContext.Produto.Select(
                    s => new ProdutoDTO
                    {
                        Id = s.Id,
                        Nome = s.Nome,
                        Codigo = s.Codigo,
                    })
                .FirstOrDefaultAsync(s => s.Id == Id);

            if (produto == null)
            {
                return NotFound();
            }
            else
            {
                return produto;
            }
        }

        [HttpPost("FiltrarProduto")]
        public async Task<ActionResult<List<ProdutoDTO>>> FiltrarProduto(FiltroProdutoDTO produto)
        {
            var List = await DBContext.Produto.Select(
                s => new ProdutoDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                }
            ).ToListAsync();

            if (produto .Id > 0)
            {
                List = List.Where(a => a.Id == produto.Id).ToList();
            }

            if (produto.Nome != null)
            {
                List = List.Where(a => a.Nome.Contains(produto.Nome)).ToList();
            }

            if (produto.Codigo != null)
            {
                List = List.Where(a => a.Codigo.Contains(produto.Codigo)).ToList();
            }

            return List;
        }

        [HttpPost("InsertProduto")]
        public async Task<HttpStatusCode> InsertProduto(ProdutoDTO produto)
        {
            var entity = new Produto()
            {
                Nome = produto.Nome,
                Codigo = produto.Codigo,
            };

            DBContext.Produto.Add(entity);
            await DBContext.SaveChangesAsync();

            return HttpStatusCode.Created;
        }

        [HttpPut("UpdateProduto")]
        public async Task<HttpStatusCode> UpdateProduto(ProdutoDTO produto)
        {
            var entity = await DBContext.Produto.FirstOrDefaultAsync(s => s.Id == produto.Id);

            entity.Id = produto.Id;
            entity.Nome = produto.Nome;
            entity.Codigo = produto.Codigo;

            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpDelete("DeleteProduto/{Id}")]
        public async Task<HttpStatusCode> DeleteProduto(int Id)
        {
            var entity = new Produto()
            {
                Id = Id
            };
            DBContext.Produto.Attach(entity);
            DBContext.Produto.Remove(entity);
            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }
    }
}
