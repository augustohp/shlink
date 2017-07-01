pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        sh 'composer install --no-interaction'
        sh 'mkdir -p build'
        sh 'composer check'
      }
    }
  }
}