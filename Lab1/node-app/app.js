const Koa = require('koa');
const app = new Koa();

app.use(async ctx => {
  ctx.body = 'This is Koa.js!';
});

const port = process.env.PORT || 3000;
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});