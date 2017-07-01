pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        sh 'composer install --no-interaction'
        sh 'mkdir build'
        sh 'composer check'
      }
    }
  }
}