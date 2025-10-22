var TEXTURE_SRC = './img/resource/section1.jpg';


  function init(img) {
    initWebGL();

    var program = createProgram('vs', 'fs');
    if (!program) return;

    // 頂点座標
    var position = [
      -1, 1, 0,
      -1, -1, 0,
      1, 1, 0,
      1, -1, 0];

    var positionCount = position.length / 3;

    // attribute 定義
    createAttribute({
      position: {
        stride: 3,
        value: position
      }
    },

      program);

    // attribute 設定
    setAttribute('position');

    // uniform 定義
    createUniform({
      time: {
        type: '1f'
      },

      texture: {
        type: '1i'
      }
    },

      program);

    // テクスチャ設定
    createTexture(img);
    setUniform('texture', 0);

    clearColor(0, 0, 0, 1);

    initSize(img.width, img.height);

    start(function (time) {
      // uniform 設定
      setUniform('time', time / 1000);
    }, 'TRIANGLE_STRIP', positionCount);
  }

$(document).ready(function () {
  loadImage(TEXTURE_SRC, init);
});

// --------------------
// library
// --------------------

var canvas = void 0, gl = void 0;
var attributes = {};
var uniforms = {};

function initWebGL() {
  canvas = document.getElementById('waveCanvas');
  gl = canvas.getContext('webgl');
  document.getElementById('canvasPage').appendChild(canvas);
}

function createShader(id) {
  var scriptElement = document.getElementById(id);
  var shader = function () {
    switch (scriptElement.type) {
      case 'x-shader/x-vertex':
        return gl.createShader(gl.VERTEX_SHADER);
      case 'x-shader/x-fragment':
        return gl.createShader(gl.FRAGMENT_SHADER);
      default:
        return;
    }

  }();

  gl.shaderSource(shader, scriptElement.textContent);
  gl.compileShader(shader);

  if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
    console.error(gl.getShaderInfoLog(shader));
    return;
  }

  return shader;
}

function createProgram(vsId, fsId) {
  var program = gl.createProgram();
  gl.attachShader(program, createShader(vsId));
  gl.attachShader(program, createShader(fsId));
  gl.linkProgram(program);

  if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
    console.error(gl.getProgramInfoLog(program));
    return;
  }

  gl.useProgram(program);
  return program;
}

function createAttribute(data, program) {
  Object.keys(data).forEach(function (key) {
    var _data$key =
      data[key], stride = _data$key.stride, value = _data$key.value;
    attributes[key] = {
      location: gl.getAttribLocation(program, key),
      stride: stride,
      vbo: createVbo(value)
    };

  });
}

function createVbo(data) {
  var vbo = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, vbo);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(data), gl.STATIC_DRAW);
  gl.bindBuffer(gl.ARRAY_BUFFER, null);
  return vbo;
}

function setAttribute(name) {
  var _attributes$name =
    attributes[name], vbo = _attributes$name.vbo, location = _attributes$name.location, stride = _attributes$name.stride;

  gl.bindBuffer(gl.ARRAY_BUFFER, vbo);
  gl.enableVertexAttribArray(location);
  gl.vertexAttribPointer(location, stride, gl.FLOAT, false, 0, 0);
}

function createUniform(data, program) {
  Object.keys(data).forEach(function (key) {
    var uniform = data[key];
    uniforms[key] = {
      location: gl.getUniformLocation(program, key),
      type: 'uniform' + uniform.type
    };

  });
}

function setUniform(name, value) {
  var uniform = uniforms[name];
  if (!uniform) return;

  gl[uniform.type](uniform.location, value);
}

function bindTexture(texture) {
  gl.activeTexture(gl.TEXTURE0);
  gl.bindTexture(gl.TEXTURE_2D, texture);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
}

function createTexture(img) {
  var texture = gl.createTexture();
  gl.bindTexture(gl.TEXTURE_2D, texture);
  gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, img);
  gl.generateMipmap(gl.TEXTURE_2D);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
  gl.bindTexture(gl.TEXTURE_2D, null);

  gl.activeTexture(gl.TEXTURE0);
  gl.bindTexture(gl.TEXTURE_2D, texture);
}

function clearColor() {
  var _gl;
  (_gl = gl).clearColor.apply(_gl, arguments);
}

function loadImage(src, callback) {
  var bgUrl = $("#waveCanvas").attr("data-bg");
  var img = new Image();
  img.addEventListener('load', function () {
    callback(img);
  });
  img.crossOrigin = 'anonymous';
  img.src = bgUrl;
}

function setSize() {
  var width = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : window.innerWidth; var height = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : window.innerHeight;
  var windowRatio = window.innerWidth / window.innerHeight;
  var imgRatio = width / height;

  if (imgRatio >= windowRatio) {
    canvas.width = window.innerWidth;
    canvas.height = window.innerWidth / imgRatio;
  } else {
    canvas.height = window.innerHeight;
    canvas.width = window.innerHeight * imgRatio;
  }

  gl.viewport(0, 0, canvas.width, canvas.height);

  setUniform('resolution', [canvas.width, canvas.height]);
}

function initSize(width, height) {
  setSize(width, height);
  window.addEventListener('resize', function () {
    setSize(width, height);
  });
}

function start(draw, mode, count) {
  function render(time) {
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

    draw(time);

    gl.drawArrays(gl[mode], 0, count);

    requestAnimationFrame(render);
  }
  requestAnimationFrame(render);
}