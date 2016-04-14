var gulp = require('gulp');
var browserify = require('gulp-browserify');

gulp.task('browserify', function() {
  return gulp.
    src('./scripts/app.js').
    pipe(browserify()).
    pipe(gulp.dest('./bin'));
});

gulp.task('watch', function() {
  gulp.watch(['./scripts/*.js'], ['browserify']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'browserify']);
