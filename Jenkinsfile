pipeline {
  agent {
    node {
      label 'master'
    }

  }
  stages {
    stage('Build') {
      steps {
        echo 'building '
        sh 'printenv'
      }
    }
    stage('Test') {
      steps {
        echo 'testing'
      }
    }
  }
}