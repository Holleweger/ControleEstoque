using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ModelBinding;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class GavetaController : ControllerBase
    {
        private readonly DBContext DBContext;

        public GavetaController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }

        [HttpGet("GetGaveta")]
        public async Task<ActionResult<List<GavetaDTO>>> Get()
        {
            var List = await DBContext.Gaveta.Select(
                s => new GavetaDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                    Gondola = new GondolaDTO()
                    {
                        Id = s.Gondola.Id,
                        Nome = s.Gondola.Nome,
                        Codigo = s.Gondola.Codigo,
                    }
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

        [HttpGet("GetGavetaById/{id}")]
        public async Task<ActionResult<GavetaDTO>> GetGavetaById(int Id)
        {
            GavetaDTO gaveta = await DBContext.Gaveta.Select(
                    s => new GavetaDTO
                    {
                        Id = s.Id,
                        Nome = s.Nome,
                        Codigo = s.Codigo,
                        Gondola = new GondolaDTO()
                        {
                            Id = s.Gondola.Id,
                            Nome = s.Gondola.Nome,
                            Codigo = s.Gondola.Codigo,
                        }
                    })
                .FirstOrDefaultAsync(s => s.Id == Id);

            if (gaveta == null)
            {
                return NotFound();
            }
            else
            {
                return gaveta;
            }
        }

        [HttpPost("InsertGaveta")]
        public async Task<HttpStatusCode> InsertGaveta(GavetaDTO gaveta)
        {
            try
            {
                var entity = new Gaveta()
                {
                    Nome = gaveta.Nome,
                    Codigo = gaveta.Codigo,
                    GondolaId = gaveta.Gondola.Id,
                };

                DBContext.Gaveta.Add(entity);
                await DBContext.SaveChangesAsync();
                return HttpStatusCode.Created;
            }
            catch (Exception ex)
            {
                var teste = ex.Message;
                return HttpStatusCode.BadRequest;
            }
        }

        [HttpPut("UpdateGaveta")]
        public async Task<HttpStatusCode> UpdateGaveta(GavetaDTO gaveta)
        {
            var entity = await DBContext.Gaveta.FirstOrDefaultAsync(s => s.Id == gaveta.Id);

            entity.Id = gaveta.Id;
            entity.Nome = gaveta.Nome;
            entity.Codigo = gaveta.Codigo;
            entity.GondolaId = gaveta.Gondola.Id;

            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpDelete("DeleteGaveta/{Id}")]
        public async Task<HttpStatusCode> DeleteGaveta(int Id)
        {
            var entity = new Gaveta()
            {
                Id = Id
            };
            DBContext.Gaveta.Attach(entity);
            DBContext.Gaveta.Remove(entity);
            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpPost("FiltrarGaveta")]
        public async Task<ActionResult<List<GavetaDTO>>> FiltrarGondola(FiltroGavetaDTO gaveta)
        {
            var List = await DBContext.Gaveta.Select(
                s => new GavetaDTO
                {
                    Id = s.Id,
                    Nome = s.Nome,
                    Codigo = s.Codigo,
                    Gondola = new GondolaDTO
                    {
                        Id = s.Gondola.Id,
                        Nome = s.Gondola.Nome,
                        Codigo = s.Gondola.Codigo,
                    }
                }
            ).ToListAsync();

            if (gaveta.Id > 0)
            {
                List = List.Where(a => a.Id == gaveta.Id).ToList();
            }

            if (gaveta.Nome != null)
            {
                List = List.Where(a => a.Nome.Contains(gaveta.Nome)).ToList();
            }

            if (gaveta.Codigo != null)
            {
                List = List.Where(a => a.Codigo.Contains(gaveta.Codigo)).ToList();
            }

            return List;
        }
    }
}
